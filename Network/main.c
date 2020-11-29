#include <stdio.h>
#include <stdlib.h>
#include "client.h"

void main()
{
    User etu;
    etu = welcome();
    connect_to_server(etu);
}