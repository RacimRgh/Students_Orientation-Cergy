#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include "db_connection.h"

void do_exit(PGconn *conn)
{
    PQfinish(conn);
    exit(1);
}

PGconn *connectDB()
{
    PGconn *conn = PQconnectdb("user=postgres password=4588 dbname=dbborne");

    if (PQstatus(conn) == CONNECTION_BAD)
    {

        fprintf(stderr, "Connection to database failed: %s\n", PQerrorMessage(conn));
        do_exit(conn);
    }
    char *user = PQuser(conn);
    char *db_name = PQdb(conn);
    char *pswd = PQpass(conn);
    printf("Connecté à la base de données !\n");
    printf("User: %s\n", user);
    printf("Database name: %s", db_name);
    printf("\n________________________________________________\n");
    return conn;
}

User insert_user(PGconn *conn, User etu)
{
    // Génération d'un ID unique de la demande
    // En utilisant: matricule étudiant + date de demande
    time_t t = time(NULL);
    struct tm tm = *localtime(&t);
    sprintf(etu.id, "%sD%02d%02d", etu.matricule, tm.tm_hour, tm.tm_min);

    // Paramètres de la requete
    const char *const paramValues[] = {etu.matricule, etu.nom, etu.prenom, etu.email, etu.tel, etu.universite, etu.specialite, etu.id};
    // Taille des paramètres
    const int paramLengths[] = {sizeof(etu.matricule), sizeof(etu.nom), sizeof(etu.prenom), sizeof(etu.email), sizeof(etu.tel), sizeof(etu.universite), sizeof(etu.specialite), sizeof(etu.id)};
    // Format des paramètres (char*)
    const int paramFormats[] = {0, 0, 0, 0, 0, 0, 0, 0};
    // Nombre de paramètres
    int nParams = 8;
    // Format du résulat (char*)
    int resultFormat = 0;
    // Requete SQL
    char cmd[] = "INSERT INTO Demandeur (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_dem) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths, paramFormats, resultFormat);
    // printf("\n\nHEREDB\n\n");
    if (PQresultStatus(res) != PGRES_COMMAND_OK)
    {
        printf("\n****Echec de l'ajout !\n");
        strcpy(etu.id, "err");
        //do_exit(conn);
    }
    PQclear(res);
    return etu;
    //PQfinish(conn);
}

char **recup_typesFAQ(PGconn *conn, char *borne, int *n)
{
    // Paramètres de la fonction PGexecparams
    // Pour faire une requete préparée
    // Code de la borne
    const char *const paramValues[] = {borne};
    const int paramLengths[] = {sizeof(borne)};
    const int paramFormats[] = {0};
    int nParams = 1;
    int resultFormat = 0;

    // Requete de récupération de la FAQ de la borne concernée
    char cmd[] = "SELECT typeFAQ from FAQ WHERE idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne=$1) GROUP BY typeFAQ;";
    //char cmd[] = "SELECT DISTINCT typeFAQ FROM FAQ WHERE idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne=$1);";
    // Execution de la requete préparée
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths, paramFormats, resultFormat);

    if (PQresultStatus(res) != PGRES_TUPLES_OK)
    {
        printf("No data retrieved\n");
        PQclear(res);
        // PQfinish(conn);
        return NULL;
    }
    int rows = PQntuples(res);
    *n = rows;
    char **types;
    types = malloc(rows * sizeof(char *));
    for (int i = 0; i < rows; i++)
    {
        types[i] = malloc(50 * sizeof(char));
        strcpy(types[i], PQgetvalue(res, i, 0));
    }
    return types;
}

QR *recup_faq(PGconn *conn, char *borne, char *type, int *n)
{
    // Paramètres de la fonction PGexecparams
    // Pour faire une requete préparée
    // Code de la borne
    const char *const paramValues[] = {type, borne};
    const int paramLengths[] = {sizeof(type), sizeof(borne)};
    const int paramFormats[] = {0, 0};
    int nParams = 2;
    int resultFormat = 0;

    // Requete de récupération de la FAQ de la borne concernée
    char cmd[] = "SELECT * FROM FAQ WHERE typeFAQ=$1 AND idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne=$2);";
    // Execution de la requete préparée
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths, paramFormats, resultFormat);

    if (PQresultStatus(res) != PGRES_TUPLES_OK)
    {
        printf("No data retrieved\n");
        PQclear(res);
        // PQfinish(conn);
        return NULL;
        // do_exit(conn);
    }
    int rows = PQntuples(res);
    *n = rows;
    // Récupération des lignes en sortie dans un tableau de questions (defini dans interfaces.h)
    QR *qr;
    qr = malloc(rows * sizeof(QR));
    for (int i = 0; i < rows; i++)
    {
        strcpy(qr[i].type, PQgetvalue(res, i, 0));
        strcpy(qr[i].titre, PQgetvalue(res, i, 1));
        strcpy(qr[i].id, PQgetvalue(res, i, 2));
        strcpy(qr[i].contenu, PQgetvalue(res, i, 3));
        strcpy(qr[i].reponse, PQgetvalue(res, i, 4));
        printf("\n%s\n-%s\n-%s\n-%s\n-%s\n", qr[i].id, qr[i].type, qr[i].titre, qr[i].contenu, qr[i].reponse);
    }
    PQclear(res);
    return qr;
}

int update_user(PGconn *conn, User etu)
{
    const char *const paramValues[] = {etu.type_dem, etu.etat_dem, etu.matricule};
    const int paramLengths[] = {sizeof(etu.type_dem), sizeof(etu.etat_dem), sizeof(etu.matricule)};
    const int paramFormats[] = {0, 0, 0};
    int nParams = 3;
    int resultFormat = 0;

    // Requete de récupération de la FAQ de la borne concernée
    char cmd[] = "UPDATE Demandeur SET type_dem=$1, etat_dem=$2 WHERE matricule_etu=$3;";
    // Execution de la requete préparée
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths, paramFormats, resultFormat);

    if (PQresultStatus(res) != PGRES_COMMAND_OK)
    {
        printf("UPDATE command failed\n");
        PQclear(res);
        return 0;
        // do_exit(conn);
    }
    PQclear(res);
    return 1;
}

int add_question(PGconn *conn, QR qr, User etu, char *borne, char *adm)
{
    sprintf(qr.id, "Q%s", etu.id);

    const char *const paramValues[] = {qr.id, qr.id, qr.date, qr.heure, adm, qr.titre, qr.contenu, borne, etu.id};
    const int paramLengths[] = {sizeof(qr.id), sizeof(qr.id), sizeof(qr.date), sizeof(qr.heure), sizeof(adm), sizeof(qr.titre), sizeof(qr.contenu), sizeof(borne), sizeof(etu.id)};
    const int paramFormats[] = {0, 0, 0, 0, 0, 0, 0, 0, 0};
    int nParams = 9;
    int resultFormat = 0;

    char cmd[] = "INSERT INTO Question (idQ, idMessage, dateMess, heureMess, admAjout, titreQ, contenuQ, id_borne, idDem) VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9);";

    // Execution de la requete préparée
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths, paramFormats, resultFormat);

    if (PQresultStatus(res) != PGRES_COMMAND_OK)
    {
        printf("UPDATE command failed\n");
        PQclear(res);
        return 0;
        // do_exit(conn);
    }

    PQclear(res);
    return 1;
}

int add_connexion(PGconn *conn, char *etuId, char *borne)
{
    char date[50], heure[50];
    time_t t = time(NULL);
    struct tm tm = *localtime(&t);

    sprintf(heure, "%02d:%02d:%02d", tm.tm_hour, tm.tm_min, tm.tm_sec);
    sprintf(date, "%d-%02d-%02d", tm.tm_year + 1900, tm.tm_mon + 1, tm.tm_mday);

    const char *const paramValues[] = {etuId, borne, date, heure};
    const int paramLengths[] = {sizeof(etuId), sizeof(borne), sizeof(date), sizeof(heure)};
    const int paramFormats[] = {0, 0, 0, 0};
    int nParams = 4;
    int resultFormat = 0;

    char cmd[] = "INSERT INTO Connexion (id_dem, id_borne, date_connexion, heure_connexion) VALUES ($1,$2,$3,$4);";
    // Execution de la requete préparée
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths, paramFormats, resultFormat);

    if (PQresultStatus(res) != PGRES_COMMAND_OK)
    {
        printf("\n****Echec de l'ajout !\n");
        PQclear(res);
        return 0;
        // do_exit(conn);
    }

    PQclear(res);
    return 1;
}