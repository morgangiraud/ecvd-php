CREATE DATABASE ecvchat;
USE ecvchat;
show databases;
CREATE TABLE users (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    -> email VARCHAR(50) NOT NULL, username VARCHAR(30), password VARCHAR(30),
    -> photo_id INT(11));
 SHOW TABLES;
 DESCRIBE users;
 CREATE TABLE files (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEy,
    -> filename VARCHAR(30) NOT NULL, path VARCHAR(30), extension  VARCHAR(30));
 CREATE TABLE messages (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    -> message VARCHAR (30) NOT NULL, created_at datetime, user_id INT(11));