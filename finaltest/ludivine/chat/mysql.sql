create database ecvchat;

create table users (id int(2) primary key auto_increment, email varchar(30), username varchar(30), password varchar(255), photo_id int(2));

create table files (id int(2) primary key auto_increment, filename varchar(30), path varchar(30), extension varchar(30));

create table messages (id int(2) primary key auto_increment, message varchar(150), created_at datetime(6), user_id int(2));