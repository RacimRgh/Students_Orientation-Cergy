#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include "client.h"

void welcome()
{
    system("clear");
    char enter = 0;
    printf("\n\t\t*********************************************************");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t**** \t Bienvenue sur la borne d'aide d'étudiants   ****");
    printf("\n\t\t**** \t Appuyez sur une touche pour commencer...    ****");
    printf("\n\t\t*********************************************************\n");
    // fflush(stdin);
    // while (enter != '\r' && enter != '\n')
    while (enter == 0)
    {
        enter = getchar();
        break;
    }
    connect_to_server();
    printf("Connexion en cours ...");
    sleep(2000);
    //system("clear");
}

User enter_information()
{
    User etu;
    printf("\n*** Veuillez entrer vos coordonnées: \n");
    printf("\nMatricule: ");
    scanf("%s", etu.matricule);
    printf("\nNom: ");
    scanf("%s", etu.nom);
    printf("\nPrenom: ");
    scanf("%s", etu.prenom);
    printf("\nTel: ");
    scanf("%s", etu.tel);
    printf("\nEmail: ");
    scanf("%s", etu.email);
    return etu;
}

void affiche(User etu)
{
    printf("**** %s ** %s ** %s ** %s ** %s", etu.nom, etu.prenom, etu.matricule, etu.tel, etu.email);
}
