#!/bin/bash
sudo mysql "Create database bonfire;"
sudo mysql "create user 'bonfire_user'@'localhost' identified by 'Password123';"
sudo mysql "GRANT ALL PRIVILEGES ON *.* to 'bonfire_user'@'localhost';"
sudo mysql "FLUSH PRIVILEGES;"