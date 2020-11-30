#include <netdb.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <signal.h>
#include <unistd.h>
#include <arpa/inet.h>
#include "client.h"

char c = 'n';
void user_stop_handler(int sig)
{
    if (sig == 2)
    {
        printf("\n/!\\ Etes-vous sur de vouloir arreter ? (o/n) \n");
        scanf("%c", &c);
    }
}

void client_func(int sockfd)
{
    signal(SIGINT, user_stop_handler);
    char buff[MAX];
    int i = 0;
    User etu;
    QR qr[MAX];
    etu = enter_information();
    bzero(buff, sizeof(buff));
    // affiche(etu);

    // Envoi du code de la borne pour authentification au serveur
    // Et pour récupération des données la concernant
    write(sockfd, "B1", sizeof("B1"));
    bzero(buff, sizeof(buff));

    // Envoi les informations de l'utilisateur au serveur pour envoyer à la BD
    sprintf(buff, "%s %s %s %s %s", etu.matricule, etu.nom, etu.prenom, etu.email, etu.tel);
    // printf("\n\n\t____**___ %s", buff);
    write(sockfd, buff, sizeof(buff));

    // Vider le buffer
    bzero(buff, sizeof(buff));

    // Récupération de la foire à question de la part du serveur
    for (;;)
    {
        read(sockfd, buff, sizeof(buff));
        if (strncmp("end", buff, 3) == 0)
            break;
        sscanf(buff, "%s %s %s %s %s", (qr + i)->id, (qr + i)->type, (qr + i)->titre, (qr + i)->contenu, (qr + i)->reponse);
        i++;
    }
    questions(qr);
}

void connect_to_server()
{
    int sockfd, connfd;
    struct sockaddr_in servaddr, cli;

    // socket create and varification
    sockfd = socket(AF_INET, SOCK_STREAM, 0);
    if (sockfd == -1)
    {
        printf("socket creation failed...\n");
        exit(0);
    }
    else
        printf("Socket successfully created..\n");
    bzero(&servaddr, sizeof(servaddr));

    // assign IP, PORT
    servaddr.sin_family = AF_INET;
    servaddr.sin_addr.s_addr = inet_addr("127.0.0.1");
    servaddr.sin_port = htons(PORT);

    // connect the client socket to server socket
    if (connect(sockfd, (SA *)&servaddr, sizeof(servaddr)) != 0)
    {
        printf("connection with the server failed...\n");
        exit(0);
    }
    else
        printf("connected to the server..\n");

    // function for chat
    client_func(sockfd);

    // close the socket
    close(sockfd);
}
