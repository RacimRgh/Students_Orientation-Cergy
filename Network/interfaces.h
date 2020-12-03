#ifndef __USERS
#define __USERS
#include <stdint.h>
typedef struct users
{
    char id[50];
    char matricule[50];
    char nom[50];
    char prenom[50];
    char email[50];
    char tel[50];
    char universite[50];
    char specialite[50];
    char type_dem[50];
    char etat_dem[50];
} User;

typedef struct questions
{
    char id[50];
    char type[50];
    char titre[50];
    char contenu[200];
    char reponse[200];
    char date[50];
    char heure[50];
} QR;

void welcome(uint16_t PORT, char *ip);
User enter_information();
void affiche(User etu);
char *typesFAQ(char **types, int n);
void questions(QR *qr);
QR formuler_question();

#endif