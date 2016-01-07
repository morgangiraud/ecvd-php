CREATE DATABASE ecvchat;


USE ecvchat;


CREATE TABLE users
(
    id int NOT NULL AUTO_INCREMENT,
    email varchar(255),
    username varchar(255),
    password varchar(255),
    photo_id int,
    PRIMARY KEY (id)
);


CREATE TABLE files
(
    id int NOT NULL AUTO_INCREMENT,
    filename varchar(255),
    path varchar(255),
    extension varchar(10),
    PRIMARY KEY (id)
);


CREATE TABLE messages
(
    id int NOT NULL AUTO_INCREMENT,
    message varchar(255),
    created_at datetime,
    user_id int,
    PRIMARY KEY (id)
);