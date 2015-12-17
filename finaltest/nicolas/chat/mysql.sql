mysql> CREATE DATABASE ecvchat;
mysql> USE ecvchat;
mysql> CREATE TABLE users (id INT PRIMARY KEY NOT NULL, email VARCHAR(255), username VARCHAR(255), password VARCHAR(255), photo_id INT);
mysql> CREATE TABLE files (id INT PRIMARY KEY NOT NULL, filename VARCHAR(255), patch VARCHAR(255), extension VARCHAR(255));
mysql> CREATE TABLE messages (id INT PRIMARY KEY NOT NULL, message VARCHAR(255), created_at DATETIME, user_id INT);