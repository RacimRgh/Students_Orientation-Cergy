#ifndef __cl
#define __cl
#include <string.h>
#include "ip_validator.h"
#include "interfaces.h"
#define MAX 1000
#define SA struct sockaddr

int client_func(int sockfd);
void connect_to_server(uint16_t P, char *ip);

#endif