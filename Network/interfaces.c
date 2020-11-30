#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
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
    printf("\n**** %s ** %s ** %s ** %s ** %s\n", etu.nom, etu.prenom, etu.matricule, etu.tel, etu.email);
}

void questions(QR *qr)
{
    // system("clear");
    // printf("\n HERE: %ld", sizeof(qr));
    printf("\n\t\t*********************************************************");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t****\tCode - Type - Titre - Question - Réponse");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************");
    for (int i = 0; i < sizeof(qr); i++)
        if (strcmp((qr + i)->id, ""))
            printf("\n\t\t****\t%s - %s - %s - %s - %s\n", (qr + i)->id, (qr + i)->type, (qr + i)->titre, (qr + i)->contenu, (qr + i)->reponse);
    int enter = 0;
    printf("\n\t\t****\t0 - Question personnalisée.");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************\n");
    printf("\n******** Votre choix ?\t(1-x) : ");
    scanf("%d", &enter);
}
