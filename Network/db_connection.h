#ifndef __db
#define __db
#include <libpq-fe.h>
#include "interfaces.h"

void do_exit(PGconn *conn);
PGconn *connectDB();
void insert_user(PGconn *conn, User etu);
QR *recup_faq(PGconn *conn, char *borne);

#endif