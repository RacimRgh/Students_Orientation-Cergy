#!/bin/bash

gcc network.c client.c interfaces.c  db_connection.c -I /usr/local/pgsql/include/ -L /usr/local/pgsql/lib/ -o network -lpq
./network
