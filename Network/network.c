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
    printf("\n****Connexion de la borne '%s' géré par l'admin '%s'\n", borne, adm);

    // Récupération des informations de l'utilisateur
    printf("\n***Attente des informations de l'utilisateur... \n");
    recv(sockfd, buff, sizeof(buff), 0);
    sscanf(buff, "%s %s %s %s %s", etu.matricule, etu.nom, etu.prenom, etu.email, etu.tel);
    tentative = 1;
    affiche(etu);
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
    // Récupération des types de requetes, pour donner un choix à l'utilisateur
    char **types;
    types = recup_typesFAQ(conn, borne, &n);
    for (int i = 0; i < n; i++)
    {
        send(sockfd, types[i], MAX, 0);
        bzero(buff, sizeof(buff));
        // printf("\n**** %s", types[i]);
    }
    send(sockfd, "end", MAX, 0);

    // Lecture du choix foire aux questions
    bzero(buff, sizeof(buff));
    recv(sockfd, buff, sizeof(buff), 0);
    strcpy(choix, buff);
    printf("\n\t___%s", choix);

    // Mettre à jour l'utilisateur avec le type de demande formulé
    strcpy(etu.type_dem, buff);
    strcpy(etu.etat_dem, "En attente");
    req = update_user(conn, etu);
    if (req)
    {
        printf("\n**Mise à jour faite!");
        send(sockfd, "OK", MAX, 0);
    }
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
                    sprintf(buff, "%s;;;%s;;;%s;;;%s;;;%s", (qr + i)->id, (qr + i)->type, (qr + i)->titre, (qr + i)->contenu, (qr + i)->reponse);
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
        printf("\nReceived1: \n%s\n", buff);
        send(sockfd, "OK", sizeof(buff), 0);
        sscanf(buff, "%[^\n]\n;%[^\n]", qrp.titre, qrp.contenu);

        bzero(buff, sizeof(buff));
        recv(sockfd, buff, sizeof(buff), 0);
        printf("\nReceived2: \n%s\n", buff);
        send(sockfd, "OK", sizeof(buff), 0);
        sscanf(buff, "%s", qrp.date);

        bzero(buff, sizeof(buff));
        recv(sockfd, buff, sizeof(buff), 0);
        printf("\nReceived3: \n%s\n", buff);
        send(sockfd, "OK", sizeof(buff), 0);
        sscanf(buff, "%s", qrp.heure);

        printf("\n\n Message reçu: \n%s\n%s\n%s\n%s\n\n", qrp.titre, qrp.contenu, qrp.date, qrp.heure);
        req = add_question(conn, qrp, etu, borne, adm);
        printf("\n****** %d ***\n", req);
    }

    printf("\n*** Attente du choix\n");
    bzero(buff, sizeof(buff));
    recv(sockfd, buff, sizeof(buff), 0);
}

// Driver function
int main(int argc, char *argv[])
{
    int sockfd, connfd, len;
    int optval, s;
    char IP[MAX];
    struct sockaddr_in servaddr, cli;
    uint16_t PORT = 8080;
    socklen_t optlen = sizeof(optval);

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

    // socket create and verification
    sockfd = socket(AF_INET, SOCK_STREAM, 0);
    if (sockfd == -1)
    {
        printf("socket creation failed...\n");
        exit(0);
    }
    else
        printf("Socket successfully created..\n");
    /* Set the option active */
    optval = 1;
    optlen = sizeof(optval);
    if (setsockopt(sockfd, SOL_SOCKET, SO_KEEPALIVE, &optval, optlen) < 0)
    {
        perror("setsockopt()");
        close(s);
        exit(EXIT_FAILURE);
    }
    printf("SO_KEEPALIVE set on socket");
    printf("\n________________________________________________\n");

    /* Check the status again */
    if (getsockopt(sockfd, SOL_SOCKET, SO_KEEPALIVE, &optval, &optlen) < 0)
    {
        perror("getsockopt()");
        close(s);
        exit(EXIT_FAILURE);
    }
    // printf("SO_KEEPALIVE is %s\n", (optval ? "ON" : "OFF"));

    inet_ntop(AF_INET, &servaddr.sin_addr.s_addr, IP, sizeof(IP));
    printf("L'adresse IP est: %s\n", IP);

    // Binding newly created socket to given IP and verification
    if ((bind(sockfd, (SA *)&servaddr, sizeof(servaddr))) != 0)
    {
        printf("socket bind failed...\n");
        exit(0);
    }
    else
        printf("Socket successfully binded..");

    // Now server is readyy to listen and verification
wait_client:
    if ((listen(sockfd, 5)) != 0)
    {
        printf("Listen failed...\n");
        exit(0);
    }
    else
        printf("\nServer listening..");
    len = sizeof(cli);
    printf("\n________________________________________________\n");
    // Connect to database
    PGconn *conn = connectDB();

    // Accept the data packet from client and verification
    connfd = accept(sockfd, (SA *)&cli, &len);
    if (connfd < 0)
    {
        printf("server acccept failed...\n");
        exit(0);
    }
    else
        printf("server acccept the client...\n");

    // Function for chatting between client and server
    server_func(connfd, conn);
    goto wait_client;
    // After chatting close the socket
    //close(sockfd);
}
