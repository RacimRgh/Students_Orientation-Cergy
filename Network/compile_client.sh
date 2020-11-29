#!/bin/bash

gcc main.c client.c interfaces.c db_connection.c -I /usr/local/pgsql/include/ -L /usr/local/pgsql/lib/ -o client -lpq
