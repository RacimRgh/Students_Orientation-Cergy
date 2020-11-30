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

        fprintf(stderr, "Connection to database failed: %s\n",
                PQerrorMessage(conn));
        do_exit(conn);
    }
    char *user = PQuser(conn);
    char *db_name = PQdb(conn);
    char *pswd = PQpass(conn);
    printf("\n______________\n Connecté à la base de données !\n");
    printf("User: %s\n", user);
    printf("Database name: %s\n__________________\n", db_name);
    // query(conn);
    // PQfinish(conn);
    return conn;
}

void insert_user(PGconn *conn, User etu)
{
    const char *const paramValues[] = {etu.matricule, etu.nom, etu.prenom, etu.email, etu.tel};
    const int paramLengths[] = {sizeof(etu.matricule), sizeof(etu.nom), sizeof(etu.prenom), sizeof(etu.email), sizeof(etu.tel)};
    const int paramFormats[] = {0, 0, 0, 0, 0};
    int nParams = 5;
    int resultFormat = 0;
    // printf("\n\n____%s ** %s ** %s ** %s ** %s", paramValues[0], paramValues[1], paramValues[2], paramValues[3], paramValues[4]);
    char cmd[] = "INSERT INTO Demandeur VALUES ($1, $2, $3, $4, $5)";
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths,
                                 paramFormats, resultFormat);
    printf("\n\nHERE\n\n");
    if (PQresultStatus(res) != PGRES_COMMAND_OK)
    {
        printf("\n**** Ajouté avec succès !\n");
        do_exit(conn);
    }
    PQclear(res);
    PQfinish(conn);
}

QR *recup_faq(PGconn *conn, char *borne)
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
    char cmd[] = "SELECT * FROM FAQ WHERE idFAQ IN (SELECT idFAQ FROM faq_borne WHERE id_borne=$1);";
    // Execution de la requete préparée
    PGresult *res = PQexecParams(conn, cmd, nParams, NULL, paramValues, paramLengths, paramFormats, resultFormat);

    if (PQresultStatus(res) != PGRES_TUPLES_OK)
    {
        printf("No data retrieved\n");
        PQclear(res);
        PQfinish(conn);
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
    PQfinish(conn);
    // printf("\n\nRows: %ld\n\n", sizeof(qr));
    return qr;
}