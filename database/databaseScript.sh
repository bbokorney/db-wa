#!/bin/bash

#Script to install the database and optionally populate with example values

#install mysql (I used 'droidbox' as the password)
#sudo apt-get install mysql-server

#make a database called droidbox
mysqladmin -u root -pdroidbox create droidbox

#populate with example code
mysql -u root -pdroidbox droidbox < currDatabase.sql 

#OR: create empty tables
#mysql -u root -pdroidbox droidbox < setup_tables.sql
