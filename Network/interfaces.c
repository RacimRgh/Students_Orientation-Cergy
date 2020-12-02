#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include "client.h"

void welcome()
{
    char enter;
AGAIN:
    system("clear");
    fflush(stdin);
    enter = 0;
    printf("\n\t\t*********************************************************");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t**** \t Bienvenue sur la borne d'aide d'étudiants   ****");
    printf("\n\t\t**** \t Appuyez sur une touche pour commencer...    ****");
    printf("\n\t\t*********************************************************\n");
    // while (enter != '\r' && enter != '\n')
    while (enter == 0)
    {
        enter = getchar();
        break;
    }
    connect_to_server();
    printf("\n****AU REVOIR !");
    sleep(2);
    goto AGAIN;
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

char *typesFAQ(char **types, int n)
{
    int choix = 0;
    // system("clear");
    printf("\n\t\t*********************************************************");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t****\tCode - Type");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************");
    for (int i = 1; i <= n; i++)
    {
        printf("\n\t\t****\t%d - %s\n", i, types[i - 1]);
    }
    printf("\n\t\t****\t0 - Question personnalisée.");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************\n");
    printf("\n******** Votre choix ?\t(1-x) : ");
    scanf("%d", &choix);
    switch (choix)
    {
    case 1:
        return types[0];
    case 2:
        return types[1];
    case 3:
        return types[2];
    default:
        return "Personnalisée";
    }
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
    // printf("\n\t\t****\t0 - Question personnalisée.");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************\n");
    printf("\n******** Votre choix ?\t(1-x) : ");
    scanf("%d", &enter);
}

QR formuler_question()
{
    int n = 0;
    char buff[MAX];
    QR qr;
    printf("\n\t\t*********************************************************");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t****Ici vous pouvez formuler votre propre question, et l'envoyer au site web pour qu'elle soit traité par un étudiant assistant");
    printf("\n\t\t*********************************************************\n");
    printf("\n\t\t****\tTitre de votre question: ");
    scanf("%s", qr.titre);
    printf("\n\t\t****\tVeuillez donner plus de détails: ");
    scanf("%s", qr.contenu);
}
