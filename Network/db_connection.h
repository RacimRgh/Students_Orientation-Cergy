#ifndef __db
#define __db
#include <libpq-fe.h>
#include "interfaces.h"

void do_exit(PGconn *conn);
PGconn *connectDB();
void insert_user(PGconn *conn, User etu);
char **recup_typesFAQ(PGconn *conn, char *borne, int *n);
QR *recup_faq(PGconn *conn, char *borne, char *type);

#endif