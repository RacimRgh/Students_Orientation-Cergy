#include <stdio.h>
#include <stdlib.h>
#include "client.h"

void main(int argc, char *argv[])
{
    uint16_t PORT = 8080;
    char ip[MAX];
    bzero(ip, sizeof(ip));
    strcpy(ip, "127.0.0.1");
    // Vérifier si le client reçoit des données par le terminal
    if (argc == 2)
    {
        sscanf(argv[1], "%hd", &PORT);
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
        bzero(ip, sizeof(ip));
        strcpy(ip, argv[2]);
    }
    //User etu;
    welcome(PORT, ip);
    //connect_to_server();
}