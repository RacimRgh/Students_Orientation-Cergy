#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include "client.h"

User welcome()
{
    system("clear");
    User etu;
    while (1)
    {
        printf("\n\t\t*********************************************************");
        printf("\n\t\t****\t\t\t\t\t\t     ****");
        printf("\n\t\t**** \t Bienvenue sur la borne d'aide d'étudiants   ****");
        printf("\n\t\t**** \t Appuyez sur une touche pour commencer...    ****");
        printf("\n\t\t*********************************************************\n");
        sleep(2);
        //system("clear");
        etu = enter_information();
        break;
    }
    return etu;
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
    return etu;
}
