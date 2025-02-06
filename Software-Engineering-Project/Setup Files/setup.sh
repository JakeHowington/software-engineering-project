#!/bin/bash

# ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
# This script is used to setup the environment for the project. It will install all the required dependencies and
# setup the project for development.
# ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
# List of all the dependencies required for the project.
# OS: OpenSuSE Leap 15.5
# Git
# PHP 8.0
# Apache 2
# mariadb
# PHPMyAdmin
# Moodle 3.11
# ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

#Set the current directory to the root home directory
cd ~

sudo zypper up -y # Update the system
#Install the required dependencies
sudo zypper in -y git mariadb php81 php81-mysql apache2 apache2-mod_php81 phpMyAdmin phpMyAdmin-apache
#Enable the php8.1 module for Apache
sudo a2enmod php8.1

# Enable and start the services
sudo systemctl enable apache2
sudo systemctl enable mariadb
sudo systemctl start apache2
sudo systemctl start mariadb

#Firewall for Apache
sudo firewall-cmd --add-service=http --permanent
sudo firewall-cmd --reload

# Secure the MariaDB installation
sudo mysql_secure_installation

# Create the database for Moodle
sudo mysql -u root -p < src/initializeDB.sql

# # Time to install Moodle
# git clone -b MOODLE_403_STABLE git://git.moodle.org/moodle.git
# #Lock the permissions
# sudo chown -R root:root moodle
# sudo chmod -R 755 moodle