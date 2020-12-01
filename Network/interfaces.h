#ifndef __USERS
#define __USERS
typedef struct users
{
    char matricule[50];
    char nom[50];
    char prenom[50];
    char email[50];
    char tel[50];
    char universite[50];
    char specialite[50];
} User;

typedef struct questions
{
    char id[50];
    char type[50];
    char titre[50];
    char contenu[200];
    char reponse[200];
} QR;

void welcome();
User enter_information();
void affiche(User etu);
char *typesFAQ(char **types, int n);
void questions(QR *qr);

#endif