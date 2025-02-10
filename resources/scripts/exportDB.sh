#!/bin/bash
DATE=$(date +%d-%b-%y-%H_%M)
mysqldump -ubonfire_user -pPassword123 --opt bonfire > ../database/dump_${DATE}.sql