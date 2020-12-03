#include <stdio.h>
#include <netdb.h>
#include <netinet/in.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <sys/types.h>
#include <unistd.h>
#include <arpa/inet.h>
#include "network.h"
#include "interfaces.h"
#include "ip_validator.h"

// Function designed for chat between client and server.
int server_func(int sockfd, PGconn *conn)
{
    char buff[MAX], borne[MAX], choix[MAX], adm[MAX];
    int n, req, tentative;
    User etu;

    bzero(borne, sizeof(borne));
    bzero(buff, sizeof(buff));
    bzero(adm, sizeof(adm));
    bzero(choix, sizeof(choix));

    // Récupération du code de la borne
    recv(sockfd, borne, sizeof(borne), 0);
    send(sockfd, "borne_ok", MAX, 0);
    recv(sockfd, adm, sizeof(adm), 0);
    send(sockfd, "adm_ok", MAX, 0);
    printf("\n________________________________________________\n");
    printf("****Connexion de la borne '%s' géré par l'admin '%s'\n", borne, adm);

    // Récupération des informations de l'utilisateur
    printf("\n***Attente des informations de l'utilisateur... \n");
    recv(sockfd, buff, sizeof(buff), 0);
    sscanf(buff, "%s %s %s %s %s", etu.matricule, etu.nom, etu.prenom, etu.email, etu.tel);
    tentative = 1;
    // Insertion de l'utilisateur dans la BD
retry:
    etu = insert_user(conn, etu);
    if (strncmp(etu.id, "err", 3) == 0 && tentative < 4)
    {
        sprintf(buff, "(%d/3)", tentative);
        send(sockfd, buff, MAX, 0);
        printf("\n****Echec de la connexion. Tentative (%d/3)", tentative);
        sleep(2);
        tentative++;
        goto retry;
    }
    if (tentative == 4)
    {
        printf("\n****Problème de connexion, veuillez réessayer plus tard.");
        send(sockfd, "FAIL", MAX, 0);
        return -1;
    }
    send(sockfd, "OK", MAX, 0);
    // Affichage de l'utilisateur connecté après succès de l'ajout
    affiche(etu);

    // Enregistrement de la connexion de l'utilisateur
    req = add_connexion(conn, etu.id, borne);
    if (req == 1)
        printf("\nAjout de la connexion de %s sur la borne %s fait !", etu.id, borne);
    if (req == 0)
        printf("\nEchec de l'ajout de la connexion de %s sur la borne %s", etu.id, borne);

    // Récupération des types de requetes, pour donner un choix à l'utilisateur
    char **types;
    types = recup_typesFAQ(conn, borne, &n);
    for (int i = 0; i < n; i++)
    {
        send(sockfd, types[i], MAX, 0);
        bzero(buff, sizeof(buff));
    }
    send(sockfd, "end", MAX, 0);

    // Lecture du choix foire aux questions
    bzero(buff, sizeof(buff));
    recv(sockfd, buff, sizeof(buff), 0);
    strcpy(choix, buff);

    // Mettre à jour l'utilisateur avec le type de demande formulé
    strcpy(etu.type_dem, buff);
    strcpy(etu.etat_dem, "En attente");
    req = update_user(conn, etu);
    if (req)
    {
        printf("\n**Mise à jour de l'utilisateur faite!");
        send(sockfd, "OK", MAX, 0);
    }
    else
        printf("\nEchec de la mise à jour de l'utilisateur (Erreur non fatale)");

    printf("\n________________________________________________\n");
    // Selon le type de la demande choisie par user, soit on récupère la FAQ, soit on attend la formulation de la question manuelle
    if (strncmp(buff, "Personnalisée", 13))
    {
        printf("\nRécupération de la FAQ des %s", buff);
        QR *qr = recup_faq(conn, borne, buff);
        if (sizeof(qr) != 0)
        {
            for (int i = 0; i < sizeof(qr); i++)
            {
                // Vérifier la validité de l'information
                if (strcmp((qr + i)->id, ""))
                {
                    sprintf(buff, "%s;%s;%s;%s;%s", (qr + i)->id, (qr + i)->type, (qr + i)->titre, (qr + i)->contenu, (qr + i)->reponse);
                    send(sockfd, buff, sizeof(buff), 0);
                    bzero(buff, sizeof(buff));
                }
            }
            send(sockfd, "end", sizeof("end"), 0);
        }
    }
    else
    {
        printf("\n****Attente de la formulation de la question");
        QR qrp;
        bzero(buff, sizeof(buff));
        recv(sockfd, buff, sizeof(buff), 0);
        send(sockfd, "OK", sizeof(buff), 0);
        sscanf(buff, "%[^\n]\n;%[^\n]", qrp.titre, qrp.contenu);

        bzero(buff, sizeof(buff));
        recv(sockfd, buff, sizeof(buff), 0);
        send(sockfd, "OK", sizeof(buff), 0);
        sscanf(buff, "%s", qrp.date);

        bzero(buff, sizeof(buff));
        recv(sockfd, buff, sizeof(buff), 0);
        send(sockfd, "OK", sizeof(buff), 0);
        sscanf(buff, "%s", qrp.heure);
        printf("\n________________________________________________\n");
        printf("Message: \n%s\n%s\nReçu le: \n%s\n à: %s\n", qrp.titre, qrp.contenu, qrp.date, qrp.heure);
        req = add_question(conn, qrp, etu, borne, adm);
    }

    printf("\n***Fin de la session de %s\n", etu.id);

    bzero(buff, sizeof(buff));
    recv(sockfd, buff, sizeof(buff), 0);
}

// Serveur réseau
int main(int argc, char *argv[])
{
    int sockfd, connfd, len;
    int optval, s;
    char IP[MAX];
    struct sockaddr_in servaddr, cli;
    uint16_t PORT = 8080;
    socklen_t optlen = sizeof(optval);

    // Vérifier si le serveur reçoit des données par le terminal
    if (argc == 1)
    {
        servaddr.sin_addr.s_addr = htonl(INADDR_ANY);
    }
    else if (argc == 2)
    {
        printf("\n________________________________________________\n");
        sscanf(argv[1], "%hd", &PORT);
        printf("Le port donné est %hd", PORT);
        printf("\n________________________________________________\n");
    }
    else if (argc == 3)
    {
        char ip[MAX];
        strcpy(ip, argv[2]);
        if (!is_valid_ip(ip))
        {
            printf("\n/!\\ l'adresse IP donnée est non valide /!\\ (%s)\n", argv[2]);
            exit(-1);
        }
        sscanf(argv[1], "%hd", &PORT);
        printf("\n________________________________________________\n");
        printf("Le port donné est %hd", PORT);
        printf("\nL'adresse IP donnée est: %s", argv[2]);
        printf("\n________________________________________________\n");
        bzero(&servaddr, sizeof(servaddr));
        servaddr.sin_addr.s_addr = inet_addr(argv[2]);
    }

    servaddr.sin_family = AF_INET;
    servaddr.sin_port = htons(PORT);

    // Création de la socket et vérification
    sockfd = socket(AF_INET, SOCK_STREAM, 0);
    if (sockfd == -1)
    {
        perror("Echec de la création de la socket...\n");
        exit(0);
    }
    else
        printf("Socket créé avec succès...\n");

    /* Activer l'option SO_KEEPALIVE pour surveiller la connexion client-serveur en cas d'arrêt brusque
    / ou temps de réponse trop long*/
    // On a modifié les paramètres de keepalive sous Linux sur les fichiers suivant
    /* 
    /proc/sys/net/ipv4/tcp_keepalive_time : En secondes, combien va t'on attendre avant de lancer la routine qui vérifie la connexion, on a mis une petite valeur pour tester (20 secondes)
    /proc/sys/net/ipv4/tcp_keepalive_intvl : En secondes, après combien de temps la routine sera relancé (en boucle)
    /proc/sys/net/ipv4/tcp_keepalive_probes : Nombre de tentatives avant de considérer la connexion rompue (si on ne reçoit aucune réponse ACK après 5 essais)
    */
    optval = 1;
    optlen = sizeof(optval);
    if (setsockopt(sockfd, SOL_SOCKET, SO_KEEPALIVE, &optval, optlen) < 0)
    {
        perror("setsockopt()");
        close(s);
        exit(EXIT_FAILURE);
    }

    // Vérifier que SO_KEEPALIVE est bien activé
    if (getsockopt(sockfd, SOL_SOCKET, SO_KEEPALIVE, &optval, &optlen) < 0)
    {
        perror("getsockopt()");
        close(s);
        exit(EXIT_FAILURE);
    }
    printf("'SO_KEEPALIVE' est activé sur la socket");
    printf("\n________________________________________________\n");

    // Conversion de l'adresse IP au format IPV4
    inet_ntop(AF_INET, &servaddr.sin_addr.s_addr, IP, sizeof(IP));

    // Lier la socket créée avec l'adresse IP et vérifier
    if ((bind(sockfd, (SA *)&servaddr, sizeof(servaddr))) != 0)
    {
        perror("Echec de la liaison de la socket...\n");
        exit(0);
    }
    else
        printf("Socket liée au port...");

    // Mettre le serveur en écoute
wait_client:
    if ((listen(sockfd, 5)) != 0)
    {
        perror("Echec de l'écoute...\n");
        exit(0);
    }
    else
        printf("\nServeur en écoute sur le port %d et IP %s", PORT, IP);
    len = sizeof(cli);
    printf("\n________________________________________________\n");

    // Se connecter à la base de données PostgreSQL
    PGconn *conn = connectDB();

    printf("Attente de la connexion d'un client...");
    // Accepter la connexion d'un client
    connfd = accept(sockfd, (SA *)&cli, &len);

    // Afficher les détails du client
    printf("\n________________________________________________\n");
    struct sockaddr_in peer;
    int peer_len;
    peer_len = sizeof(peer);
    if (getpeername(sockfd, (struct sockaddr *)&peer, &peer_len))
    {
        printf("L'adresse IP du client est: %s\n", inet_ntoa(peer.sin_addr));
        printf("Le client est connecté sur: %d\n", (int)ntohs(peer.sin_port));
    }
    if (connfd < 0)
    {
        perror("Echec de l'acceptation du client...\n");
        exit(0);
    }
    else
        printf("Client accepté par le serveur...");
    printf("\n________________________________________________\n");
    // Fonction de gestion d'une session client-serveur
    server_func(connfd, conn);
    goto wait_client;

    //close(sockfd);
}
