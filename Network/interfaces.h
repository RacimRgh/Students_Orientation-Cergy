typedef struct users
{
    char matricule[50];
    char nom[50];
    char prenom[50];
    char email[50];
    char tel[50];
} User;

User welcome();
User enter_information();