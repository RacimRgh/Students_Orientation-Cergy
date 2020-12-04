#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <time.h>
#include "client.h"

void welcome(uint16_t PORT, char *ip)
{
    char enter;
AGAIN:
    system("clear");
    enter = getchar();
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
    connect_to_server(PORT, ip);
    sleep(2);
    goto AGAIN;
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
    printf("\nUniversité: ");
    scanf("%s", etu.universite);
    printf("\nSpécialité: ");
    scanf("%s", etu.specialite);
    return etu;
}

void affiche(User etu)
{
    printf("\n________________________________________________\n");
    printf("Utilisateur ajouté:");
    printf("\n\tID : %s", etu.id);
    printf("\n\tMatricule : %s", etu.matricule);
    printf("\n\tNom et prénom : %s %s", etu.nom, etu.prenom);
    printf("\n\tTéléphone : %s", etu.tel);
    printf("\n\tEmail : %s", etu.matricule);
    printf("\n\tUniversité : %s", etu.universite);
    printf("\n\tSpécialité : %s", etu.specialite);
    printf("\n________________________________________________\n");
}

char *typesFAQ(char **types, int n)
{
    int choix = 0;
    printf("\nVeuillez patienter...");
    printf("\n________________________________________________________________________________________________________________");
    sleep(3);
    printf("\n\t\t*********************************************************");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t****\tCode - Type");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************");
    for (int i = 1; i <= n; i++)
    {
        printf("\n\t\t****\t%d - %s", i, types[i - 1]);
        printf("\n\t\t****\t\t\t\t\t\t     ****");
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
    printf("\n________________________________________________________________________________________________________________");
    printf("\n\t\t*********************************************************");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t****\tCode - Type - Titre - Question - Réponse");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************");
    for (int i = 0; i < sizeof(qr); i++)
        if (strcmp((qr + i)->id, ""))
        {
            printf("\n________________________________________________________________________________________________________________");
            printf("\n\t\t****\nN°: %s - %s ", (qr + i)->id, (qr + i)->type);
            printf("\n\t\t****\n\n-Titre: %s", (qr + i)->titre);
            printf("\n\t\t****\n\n-Description: %s", (qr + i)->contenu);
            printf("\n\t\t****\n\n-Reponse: %s", (qr + i)->reponse);
            printf("\n________________________________________________________________________________________________________________");
        }
    int enter = 0;
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************");
    printf("\n________________________________________________________________________________________________________________");
    printf("\nVoici la FAQ de cette borne, tapez 'entrée' pour recommencer ou quitter ...");
    char ch = getchar();
    ch = getchar();
}

QR formuler_question()
{
    QR qr;
    char ch;
    char buff[MAX];
    int n = 0;

    printf("\n\t***Vous avez choisi de formuler une question manuellement.");
    printf("\nVeuillez patienter...");
    printf("\n________________________________________________________________________________________________________________");
    sleep(3);
    printf("\n\t\t*********************************************************");
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t****Ici vous pouvez formuler votre propre question,\n et l'envoyer au site web pour qu'elle soit traité par un étudiant assistant");
    printf("\n\t\t*********************************************************\n");
    printf("\n\t\t****\tTitre de votre question: ");
    // scanf("%[^\n]", qr.titre);
    ch = getchar();
    fgets(qr.titre, MAX, stdin);

    printf("\n\t\t****\tVeuillez donner plus de détails: ");
    ch = getchar();
    fgets(qr.contenu, MAX, stdin);
    // scanf("%[^\n]", qr.contenu);

    // Récupération de la date et heure actuelle
    time_t t = time(NULL);
    struct tm tm = *localtime(&t);
    sprintf(qr.date, "%d-%02d-%02d", tm.tm_year + 1900, tm.tm_mon + 1, tm.tm_mday);
    sprintf(qr.heure, "%02d:%02d:%02d", tm.tm_hour, tm.tm_min, tm.tm_sec);
    printf("\n\t\t****\t\t\t\t\t\t     ****");
    printf("\n\t\t*********************************************************");
    printf("\n________________________________________________________________________________________________________________");
    printf("\nVotre question à bien été prise en compte, tapez 'entrée' pour recommencer ou quitter ...");
    ch = getchar();
    return qr;
}
