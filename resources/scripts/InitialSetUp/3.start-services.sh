#!/bin/bash
sudo service mysql start
sudo service apache2 start
sudo service --status-all | grep -Ei 'mysql|apache2'