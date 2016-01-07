create table `files` (
  id int primary key not null,
  filename varchar(255),
  path varchar(255),
  extension varchar(127)
);
alter table `users` add image_id int;