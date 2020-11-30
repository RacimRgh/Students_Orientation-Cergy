#include <stdio.h>
#include <netdb.h>
#include <netinet/in.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <sys/types.h>
#include "network.h"
#include "interfaces.h"

// Function designed for chat between client and server.
void server_func(int sockfd, PGconn *conn)
{
    char buff[MAX];
    int n;
    User etu;
    read(sockfd, buff, sizeof(buff));
    strcpy(etu.matricule, buff);
    read(sockfd, buff, sizeof(buff));
    strcpy(etu.nom, buff);
    read(sockfd, buff, sizeof(buff));
    strcpy(etu.prenom, buff);
    read(sockfd, buff, sizeof(buff));
    strcpy(etu.email, buff);
    read(sockfd, buff, sizeof(buff));
    strcpy(etu.tel, buff);
    affiche(etu);
    insert_user(conn, etu);
    // printf("\nHERE");
    // infinite loop for chat
    // for (int i = 0; i < 5; i++)
    // {
    //     bzero(buff, MAX);

    //     // read the message from client and copy it in buffer
    //     read(sockfd, buff, sizeof(buff));
    //     // print buffer which contains the client contents
    //     printf("From client: %s");
    //     bzero(buff, MAX);
    //     // n = 0;
    //     // // copy server message in the buffer
    //     // while ((buff[n++] = getchar()) != '\n')
    //     //     ;

    //     // // and send that buffer to client
    //     // write(sockfd, buff, sizeof(buff));

    //     // // if msg contains "Exit" then server exit and chat ended.
    //     // if (strncmp("exit", buff, 4) == 0)
    //     // {
    //     //     printf("Server Exit...\n");
    //     //     break;
    //     // }
    // }
}

// Driver function
int main()
{
    int sockfd, connfd, len;
    struct sockaddr_in servaddr, cli;

    // socket create and verification
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
    servaddr.sin_addr.s_addr = htonl(INADDR_ANY);
    servaddr.sin_port = htons(PORT);

    // Binding newly created socket to given IP and verification
    if ((bind(sockfd, (SA *)&servaddr, sizeof(servaddr))) != 0)
    {
        printf("socket bind failed...\n");
        exit(0);
    }
    else
        printf("Socket successfully binded..\n");

    // Now server is ready to listen and verification
    if ((listen(sockfd, 5)) != 0)
    {
        printf("Listen failed...\n");
        exit(0);
    }
    else
        printf("Server listening..\n");
    len = sizeof(cli);

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

    // After chatting close the socket
    close(sockfd);
}
