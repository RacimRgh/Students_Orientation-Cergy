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
    printf("\n\n____%s ** %s ** %s ** %s ** %s", paramValues[0], paramValues[1], paramValues[2], paramValues[3], paramValues[4]);
    char stm[] = "INSERT INTO Etudiant VALUES ($1, $2, $3, $4, $5)";
    PGresult *res = PQexecParams(conn, stm, nParams, NULL, paramValues, paramLengths,
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