#!/bin/bash

script serveur.txt
gcc network.c client.c interfaces.c  db_connection.c ip_validator.c -I /usr/local/pgsql/include/ -L /usr/local/pgsql/lib/ -o network -lpq
