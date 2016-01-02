CREATE DATABASE ecvchat;
USE ecvchat;
CREATE TABLE users (
  id INT(4) PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(511) NOT NULL,
  photo_id INT(4)
);
CREATE TABLE files (
  id INT(4) PRIMARY KEY AUTO_INCREMENT,
  filename VARCHAR(255),
  path VARCHAR(511),
  extension VARCHAR(7)
);
CREATE TABLE messages (
  id INT(4) PRIMARY KEY AUTO_INCREMENT,
  message VARCHAR(255),
  created_at DATETIME,
  user_id INT(4)
);