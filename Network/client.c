#include <netdb.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <signal.h>
#include "client.h"

char c = 'n';
void user_stop_handler(int sig)
{
    if (sig == 2)
    {
        printf("Etes-vous sur de vouloir arreter ? (o/n) \n");
        scanf("%c", &c);
        exit(0);
    }
}

void client_func(int sockfd)
{
    signal(SIGINT, user_stop_handler);
    char buff[MAX];
    User etu;
    etu = enter_information();
    affiche(etu);
    int n;
    do
    {
        // bzero(buff, sizeof(buff));
        // printf("Enter the string : ");
        // n = 0;
        // while ((buff[n++] = getchar()) != '\n')
        //     ;
        write(sockfd, etu.matricule, sizeof(buff));
        write(sockfd, etu.nom, sizeof(buff));
        write(sockfd, etu.prenom, sizeof(buff));
        write(sockfd, etu.email, sizeof(buff));
        write(sockfd, etu.tel, sizeof(buff));
        bzero(buff, sizeof(buff));
        read(sockfd, buff, sizeof(buff));
        printf("From Server : %s", buff);
        if ((strncmp(buff, "exit", 4)) == 0)
        {
            printf("Client Exit...\n");
            break;
        }
    } while (c == 'n');
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

    // printf("\n***************** Welcome %s %s !", etu.nom, etu.prenom);

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
