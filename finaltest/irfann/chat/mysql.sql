mysql -uroot
CREATE DATABASE ecvchat;
use ecvchat;
create table users(id int NOT NULL AUTO_INCREMENT, email varchar(255), username varchar(255), password varchar(255), photo_id int, PRIMARY KEY (id));
create table files(id int NOT NULL AUTO_INCREMENT, filename varchar(255), path varchar(255), extension varchar(255), PRIMARY KEY (id));
create table messages(id int NOT NULL AUTO_INCREMENT, message varchar(255), created_at datetime, user_id int, PRIMARY KEY (id));
