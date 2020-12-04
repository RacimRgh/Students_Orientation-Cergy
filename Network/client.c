#include <netdb.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <signal.h>
#include <unistd.h>
#include <arpa/inet.h>
#include "client.h"

// On déclare cette variable globalement pour pouvoir fermer le client à tout moment
// grace aux signaux (En particulier SIGINT qui arrive avec CTRL+C qui peut être équivalent à la fermeture busque du programme)
int sockfd;
char c = 'n';
void user_stop_handler(int sig)
{
    if (sig == 2)
    {
        printf("\n/!\\ Etes-vous sur de vouloir arreter ? (o/n) \n");
        scanf("%c", &c);
        if (c == 'o')
        {
            write(sockfd, "EXIT", 4);
            close(sockfd);
            exit(0);
        }
    }
}

int client_func(int sockfd)
{
    signal(SIGINT, user_stop_handler);
    int i = 0;
    char **types;
    char buff[MAX];
    QR qr[MAX];
    User etu;

    types = malloc(3 * sizeof(char *));

    // Envoi du code de la borne pour authentification au serveur
    // Et pour récupération des données la concernant
    bzero(buff, sizeof(buff));
    send(sockfd, "B1", sizeof("B1"), 0);
    recv(sockfd, buff, sizeof(buff), 0);
    bzero(buff, sizeof(buff));
    send(sockfd, "A1", sizeof("A1"), 0);
    recv(sockfd, buff, sizeof(buff), 0);
    bzero(buff, sizeof(buff));

    // Demander les informations de l'utilisateur
    etu = enter_information();
    //affiche(etu);

    // Envoi les informations de l'utilisateur au serveur pour envoyer à la BD
    sprintf(buff, "%s %s %s %s %s", etu.matricule, etu.nom, etu.prenom, etu.email, etu.tel);
    // printf("\n\n\t____**___ %s", buff);
    send(sockfd, buff, sizeof(buff), 0);

    // Vider le buffer
    bzero(buff, sizeof(buff));
    recv(sockfd, buff, sizeof(buff), 0);
    if (strncmp(buff, "OK", 2))
    {
        for (;;)
        {
            printf("\n****Echec de la connexion. Tentative %s", buff);
            bzero(buff, sizeof(buff));
            recv(sockfd, buff, sizeof(buff), 0);
            // Si on reçoit FAIL, on arrête le client
            if (strncmp(buff, "FAIL", 4) == 0)
            {
                printf("\n*****\nArret de la session...\n");
                return -1;
            }
        }
    }

    // Récupération des types de questions de la FAQ
    i = 0;
    for (;;)
    {
        recv(sockfd, buff, MAX, 0);
        if (strncmp("end", buff, 3) == 0)
            break;
        types[i] = malloc(50 * sizeof(char));
        strcpy(types[i], buff);
        i++;
        bzero(buff, sizeof(buff));
    }
    // Envoi au serveur du type demandé pour récupérer les questions réponses correspondantes
    char *choix = typesFAQ(types, 3);
    send(sockfd, choix, MAX, 0);

    // Attente du OK
    bzero(buff, sizeof(buff));
    recv(sockfd, buff, sizeof(buff), 0);
    if (!strncmp(buff, "OK", 2))
    {
        if (strncmp(choix, "Personnalisée", 13))
        {
            // Récupération de la foire à question de la part du serveur
            for (;;)
            {
                recv(sockfd, buff, sizeof(buff), 0);
                if (strncmp("end", buff, 3) == 0)
                    break;
                sscanf(buff, "%[^\n];%[^\n];%[^\n];%[^\n];%[^\n]", (qr + i)->id, (qr + i)->type, (qr + i)->titre, (qr + i)->contenu, (qr + i)->reponse);
                i++;
            }
            questions(qr);
        }
        else
        {
            QR qrp;
            qrp = formuler_question();
            bzero(buff, sizeof(buff));
            sprintf(buff, "%s;%s", qrp.titre, qrp.contenu);
            printf("\n_______\n%s\n", buff);
            send(sockfd, buff, sizeof(buff), 0);
            recv(sockfd, buff, sizeof(buff), 0);
            bzero(buff, sizeof(buff));

            sprintf(buff, "%s", qrp.date);
            printf("\n_______\n%s\n", buff);
            send(sockfd, buff, sizeof(buff), 0);
            recv(sockfd, buff, sizeof(buff), 0);
            bzero(buff, sizeof(buff));

            sprintf(buff, "%s", qrp.heure);
            printf("\n_______\n%s\n", buff);
            send(sockfd, buff, sizeof(buff), 0);
            recv(sockfd, buff, sizeof(buff), 0);
            bzero(buff, sizeof(buff));
        }
    }
    else
    {
        printf("\n***Une erreur est survenue, veuillez patienter");
    }
}

void connect_to_server(uint16_t P, char *ip)
{
    int connfd;
    struct sockaddr_in servaddr, cli;

    printf("Connecté au serveur via l'adresse %s et port %hd..\n", ip, P);
    // Création et vérification de la socket
    sockfd = socket(AF_INET, SOCK_STREAM, 0);
    if (sockfd == -1)
    {
        perror("Création socket échouée...\n");
        exit(0);
    }
    else
        printf("Création socket réussie..\n");
    bzero(&servaddr, sizeof(servaddr));

    // Assigner IP et PORT
    servaddr.sin_family = AF_INET;
    servaddr.sin_addr.s_addr = inet_addr(ip);
    servaddr.sin_port = htons(P);

    // connect the client socket to server socket
    if (connect(sockfd, (SA *)&servaddr, sizeof(servaddr)) != 0)
    {
        perror("Connexion au serveur échouée...\n");
        exit(0);
    }
    else
        printf("Connecté au serveur via l'adresse %s et port %hd..\n", ip, P);

    // function for chat
    client_func(sockfd);

    // close the socket
    close(sockfd);
}
