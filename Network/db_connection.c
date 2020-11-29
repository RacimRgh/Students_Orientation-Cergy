#include <stdio.h>
#include <stdlib.h>
#include "db_connection.h"

void do_exit(PGconn *conn)
{

    PQfinish(conn);
    exit(1);
}

void connectDB()
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
    printf("\n\n Connecté à la base de donnés !");
    printf("User: %s\n", user);
    printf("Database name: %s\n", db_name);

    PQfinish(conn);
}