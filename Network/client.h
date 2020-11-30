#ifndef __cl
#define __cl
#include "interfaces.h"
#define MAX 1000
#define PORT 8080
#define SA struct sockaddr

void client_func(int sockfd);
void connect_to_server();

#endif