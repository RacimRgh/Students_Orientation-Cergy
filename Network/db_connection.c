#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "db_connection.h"

void do_exit(PGconn *conn)
{
    PQfinish(conn);
    exit(1);
}

PGconn *connectDB()
{
    PGconn *conn = PQconnectdb("user=postgres password=4588 dbname=test");

    if (PQstatus(conn) == CONNECTION_BAD)
    {

        fprintf(stderr, "Connection to database failed: %s\n", PQerrorMessage(conn));
        do_exit(conn);
    }
    char *user = PQuser(conn);
    char *db_name = PQdb(conn);
    char *pswd = PQpass(conn);
    printf("\n______________\n Connecté à la base de données !\n");
    printf("User: %s\n", user);
    printf("Database name: %s\n__________________\n", db_name);
    return conn;
}

int insert_user(PGconn *conn, User etu)
{
    const char *const paramValues[] = {etu.matricule, etu.nom, etu.prenom, etu.email, etu.tel};
    const int paramLengths[] = {sizeof(etu.matricule), sizeof(etu.nom), sizeof(etu.prenom), sizeof(etu.email), sizeof(etu.tel)};
    const int paramFormats[] = {0, 0, 0, 0, 0};
    int nParams = 5;
    int resultFormat = 0;
    char cmd[] = "INSERT INTO Demandeur VALUES ($1, $2, $3, $4, $5)";
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths, paramFormats, resultFormat);
    // printf("\n\nHEREDB\n\n");
    if (PQresultStatus(res) != PGRES_COMMAND_OK)
    {
        printf("\n****Echec de l'ajout !\n");
        //do_exit(conn);
    }
    PQclear(res);
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
    char cmd[] = "SELECT DISTINCT typeFAQ FROM FAQ WHERE idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne=$1);";
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

QR *recup_faq(PGconn *conn, char *borne, char *type)
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
    // printf("\n\nRows: %d\n\n", rows);
    // Récupération des lignes en sortie dans un tableau de questions (defini dans interfaces.h)
    QR *qr;
    qr = malloc(rows * sizeof(QR));
    for (int i = 0; i < rows; i++)
    {
        strcpy(qr[i].id, PQgetvalue(res, i, 0));
        strcpy(qr[i].type, PQgetvalue(res, i, 1));
        strcpy(qr[i].titre, PQgetvalue(res, i, 2));
        strcpy(qr[i].contenu, PQgetvalue(res, i, 3));
        strcpy(qr[i].reponse, PQgetvalue(res, i, 4));
        // printf("\n%s - %s - %s - %s - %s\n", qr[i].id, qr[i].type, qr[i].titre, qr[i].contenu, qr[i].reponse);
    }
    PQclear(res);
    //PQfinish(conn);
    // printf("\n\nRows: %ld\n\n", sizeof(qr));
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