#ifndef __db
#define __db
#include <libpq-fe.h>
#include "interfaces.h"

void do_exit(PGconn *conn);
PGconn *connectDB();
User insert_user(PGconn *conn, User etu);
char **recup_typesFAQ(PGconn *conn, char *borne, int *n);
QR *recup_faq(PGconn *conn, char *borne, char *type);
int update_user(PGconn *conn, User etu);
int add_question(PGconn *conn, QR qr, User etu, char *borne, char *adm);
int add_connexion(PGconn *conn, char *etuId, char *borne);

#endif