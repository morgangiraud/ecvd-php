CREATE DATABASE ecvdphp;
USE ecvdphp;
CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(255),
  email VARCHAR(255),
  password VARCHAR(255),
  description VARCHAR(511),
  PRIMARY KEY (ID)
);