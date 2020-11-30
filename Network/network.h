#ifndef __NET
#define __NET
#include "db_connection.h"
#define MAX 1000
#define PORT 8080
#define SA struct sockaddr

void server_func(int sockfd, PGconn *conn);

#endif
