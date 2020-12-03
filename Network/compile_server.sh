#!/bin/bash

gcc network.c client.c interfaces.c  db_connection.c ip_validator.c -I /usr/local/pgsql/include/ -L /usr/local/pgsql/lib/ -o network -lpq
./network 8080 127.0.0.1 2>&1 | tee server.txt
