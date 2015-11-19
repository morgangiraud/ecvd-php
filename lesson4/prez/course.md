# PHP / MySQL
## Diving into Mysql

*Pre-requisites: lesson 3*

*ECV Digital - 05/11/2015*

---
# Setting up

Set up your environment:
- Pull your own repo and the teacher's repo. 
- Move into the lesson4 exercice folder 
- Create a folder with your name, move into it

---
# MySQL
What is [Mysql](https://en.wikipedia.org/wiki/MySQL) <!-- .element: target="_blank" -->

- An Open-source software
- A Database
- A Structured Query Language ([SQL](https://en.wikipedia.org/wiki/SQL)) <!-- .element: target="_blank" -->
 
--
# Installation
Install mysql
```bash
brew install mysql
```

Launch the deamon
```bash
mysqld_safe
```
> Follow the instruction given by the shell

---
# Configuration
Access the mysql console
```
mysql -u username -p
```

1. [Add a user](http://dev.mysql.com/doc/refman/5.7/en/adding-users.html) to avoid using the root user <!-- .element: target="_blank" -->
2. Check your users: `SELECT User from mysql.user;`
3. Show current database ` show databases;`
4. Create a database named "ecvdphp" thanks to this [MySQL tutorial](http://dev.mysql.com/doc/refman/5.7/en/database-use.html) to: <!-- .element: target="_blank" -->
5. Create a table named "users" with the following fields
  - `id, username, email, password`

[More on table handling](http://sql.sh/cours/alter-table) <!-- .element: target="_blank" -->

--
# GUI

A good GUI: [sequel pro](http://www.sequelpro.com/) <!-- .element: target="_blank" --> 
- Install it
- Get access to your db
- Check the DB users
- Change your user access to only have (INSERT, SELECT, UPDATE, DELETE)

---
# Workflow
- You connect to the database server
- You select the good database
- You make queries
- You disconnect from the database

> Everytime you have to check is an error happened

--
# The old way
Using the [MySQL PHP extension](http://php.net/manual/fr/intro.mysql.php) <!-- .element: target="_blank" -->

```php
<?php
$link = mysql_connect("localhost", "mysql_user", "mysql_password") 
  or die("Impossible de se connecter : " . mysql_error());

$db = mysql_select_db('foo', $link)
  or die('Impossible de sélectionner la base de données : ' . mysql_error());

$result = mysql_query('SELECT * WHERE 1=1')
  or die('Requête invalide : ' . mysql_error());

mysql_close($link);
?>
```

--
# The old way
- An extension only for MySQL
- You must track state yourself (connection, database, etc.)
- You must do all the security yourself
- Will be removed in PHP7

> Don't use it

--
# The new way
The [PDO object](http://php.net/manual/fr/class.pdo.php) <!-- .element: target="_blank" -->

```php
<?php
try{
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
  $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Activate exception
} catch (\PDOException $e){
  echo $e->getMessage();
}

$result = $conn->query('SELECT ...');
?>
```

--
# The new way
Why you [should (must) use it](http://code.tutsplus.com/tutorials/why-you-should-be-using-phps-pdo-for-database-access--net-12059) <!-- .element: target="_blank" -->
- More secure
- Using exceptions
- You can switch database seemlessly since it is as database abstraction layer

> Use it!

--
# Exercice
> Rework your login/signin system using the PDO object!

- Change your file credentials with a MySQL repo
- Configure your database to have a users table
- Use a INSERT query to insert a new line in your table users

> [INSERT syntax](http://dev.mysql.com/doc/refman/5.7/en/insert.html) <!-- .element: target="_blank" -->

--
# SELECT
> Rework your login system
Add the feature: **Profile page**

- Change your login system to fetch data from the database using a SELECT query
- Add a "My profile" link to the user dashboard to access the profile page
- Use a SELECT query to fetch data from your DB

> [SELECT syntax](http://dev.mysql.com/doc/refman/5.7/en/select.html) <!-- .element: target="_blank" -->

--
# UPDATE
> Add the feature: **Update your profile**

- Change the static profile page into a form
- Add an update button
- When the user click on it, use an UPDATE query to update the DB

> [UPDATE syntax](http://dev.mysql.com/doc/refman/5.7/en/update.html) <!-- .element: target="_blank" -->

--
# DELETE
> Add the feature: Delete your account

- Add a link in the profile page to delete the accout
- Ask the user to enter its password
- If everything is ok, delete the account using a DELETE query

> [DELETE syntax](http://dev.mysql.com/doc/refman/5.7/en/delete.html) <!-- .element: target="_blank" -->