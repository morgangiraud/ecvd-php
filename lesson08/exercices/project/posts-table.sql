create table posts(
  id INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  body TEXT,
  user_id INT(11),
  image_id INT(11),
  created_at DATETIME
)