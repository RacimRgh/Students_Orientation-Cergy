#!/bin/bash

script client.txt
gcc main.c client.c interfaces.c ip_validator.c -o client
