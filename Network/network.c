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

// Function designed for chat between client and server.
int server_func(int sockfd, PGconn *conn)
{
    char buff[MAX], borne[MAX], choix[MAX];
    bzero(borne, sizeof(borne));
    bzero(buff, sizeof(buff));
    int n, req, tentative;
    User etu;

    // Récupération du code de la borne
    read(sockfd, borne, sizeof(borne));
    bzero(buff, sizeof(buff));

    // Récupération des informations de l'utilisateur
    read(sockfd, buff, sizeof(buff));
    sscanf(buff, "%s %s %s %s %s", etu.matricule, etu.nom, etu.prenom, etu.email, etu.tel);
    tentative = 1;
retry:
    affiche(etu);
    req = insert_user(conn, etu);
    if (req == 0 && tentative < 4)
    {
        sprintf(buff, "(%d/3)", tentative);
        write(sockfd, buff, MAX);
        printf("\n****Echec de la connexion. Tentative (%d/3)", tentative);
        sleep(2);
        tentative++;
        goto retry;
    }
    if (tentative == 4)
    {
        printf("\n****Problème de connexion, veuillez réessayer plus tard.");
        write(sockfd, "FAIL", MAX);
        return -1;
    }
    write(sockfd, "OK", MAX);
    // Récupération des types de requetes, pour donner un choix à l'utilisateur
    char **types;
    types = recup_typesFAQ(conn, borne, &n);
    for (int i = 0; i < n; i++)
    {
        write(sockfd, types[i], MAX);
        bzero(buff, sizeof(buff));
        // printf("\n**** %s", types[i]);
    }
    write(sockfd, "end", MAX);

    // Lecture du choix foire aux questions
    bzero(buff, sizeof(buff));
    read(sockfd, buff, sizeof(buff));
    strcpy(choix, buff);
    printf("\n\t___%s", choix);

    // Mettre à jour l'utilisateur avec le type de demande formulé
    strcpy(etu.type_dem, buff);
    strcpy(etu.etat_dem, "En attente");
    req = update_user(conn, etu);
    if (req)
    {
        printf("\n**Mise à jour faite!");
        write(sockfd, "OK", MAX);
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
                    sprintf(buff, "%s %s %s %s %s", (qr + i)->id, (qr + i)->type, (qr + i)->titre, (qr + i)->contenu, (qr + i)->reponse);
                    write(sockfd, buff, sizeof(buff));
                    bzero(buff, sizeof(buff));
                }
            }
            write(sockfd, "end", sizeof("end"));
        }
    }
    else
    {
        printf("\n****Attente de la formulation de la question");
        sleep(30);
    }

    printf("\n*** Attente du choix\n");
    bzero(buff, sizeof(buff));
    read(sockfd, buff, sizeof(buff));
    //insert_user(conn, etu);
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
    int s;
    int optval;
    socklen_t optlen = sizeof(optval);

    // socket create and verification
    sockfd = socket(AF_INET, SOCK_STREAM, 0);
    if (sockfd == -1)
    {
        printf("socket creation failed...\n");
        exit(0);
    }
    else
        printf("Socket successfully created..\n");

    /* Check the status for the keepalive option */
    if (getsockopt(sockfd, SOL_SOCKET, SO_KEEPALIVE, &optval, &optlen) < 0)
    {
        perror("getsockopt()");
        close(s);
        exit(EXIT_FAILURE);
    }
    printf("SO_KEEPALIVE is %s\n", (optval ? "ON" : "OFF"));

    /* Set the option active */
    optval = 1;
    optlen = sizeof(optval);
    if (setsockopt(sockfd, SOL_SOCKET, SO_KEEPALIVE, &optval, optlen) < 0)
    {
        perror("setsockopt()");
        close(s);
        exit(EXIT_FAILURE);
    }
    printf("SO_KEEPALIVE set on socket\n");

    /* Check the status again */
    if (getsockopt(sockfd, SOL_SOCKET, SO_KEEPALIVE, &optval, &optlen) < 0)
    {
        perror("getsockopt()");
        close(s);
        exit(EXIT_FAILURE);
    }
    printf("SO_KEEPALIVE is %s\n", (optval ? "ON" : "OFF"));

    // assign IP, PORT
    bzero(&servaddr, sizeof(servaddr));
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
wait_client:
    if ((listen(sockfd, 5)) != 0)
    {
        printf("Listen failed...\n");
        exit(0);
    }
    else
        printf("\n_____________________________\nServer listening..\n");
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
    goto wait_client;
    // After chatting close the socket
    //close(sockfd);
}
