# PHP / MySQL
## MySQL (part 2) and Exceptions

*Pre-requisites: lesson 4*

*ECV Digital - 05/11/2015*

---
# Security
## SQL Injection

Remember, SQL is a language, which means it has a lot alike any other language as PHP.

Especially, you  can find comment in SQL:
```sql
SELECT * FROM table; -- I'm a comment, cool!
```
In SQL, comments are as simple as typing `--`;

What if a user add such characters in an unprotected SQL query ?

--
## SQL Injection 
A simple query like:
```sql
SELECT * FROM users WHERE username='username' AND password='password'
```
could become:
```sql
SELECT * FROM users WHERE username='username' -- ' AND password='password'
```
The last query would return all the data of the user based only on the username ...

--
## Example
Let's try a simple sql injection on the login system:
- Write a good username in the username input
- Write this comment injection in the password input: 
```
' or 1 -- pawned
```
And see if you can logged in.

> I've added the word 'pawned' not only for fun but because the extra whitespace between the `--` and the word is important for a comment to work
--
## Worst
SQL injection could be very, very bad.
I've made an example in the lesson4 exercice folder: the file profile.php is completely unprotected

What could we do with that ?

We could change the password of an other user! <!-- .element: class="fragment" -->

> Find the SQL injection you could perform tu update an other user password

<!-- .element: class="fragment" -->

[The Wikipedia article is good, check it !](https://en.wikipedia.org/wiki/SQL_injection) <!-- .element: target="_blank" -->

---
## Avoiding SQL injection
Prepare your statement with the [prepare function](http://php.net/manual/fr/pdo.prepare.php) <!-- .element: target="_blank" -->

```php
<?php
// Prepare the statement
$stmt = $conn->prepare('SELECT username, email
    FROM users
    WHERE username = ? AND password = ?');
// Execute the query
$stmt->execute(array('bob', 'pwd'));
// Fetch the result
$red = $stmt->fetchAll()
?>
```

--
## Binding variables
Improve the control you have on data you send to your database with variables bindings
  - [Binding parameters](http://php.net/manual/fr/pdostatement.bindparam.php) <!-- .element: target="_blank" -->
  - [Binding values](http://php.net/manual/fr/pdostatement.bindvalue.php) <!-- .element: target="_blank" -->

```php
<?php
// Prepare the statement
$stmt = $conn->prepare('SELECT username, email
    FROM users
    WHERE username = :username AND password = :password');

// Bind params
$stmt->bindParam(':username', $username, PDO::PARAM_STR)
// Execute the query
$stmt->execute();
// Fetch the result
$red = $stmt->fetchAll()
?>
```
Check all the [param types]()

--
# Exercice
- Change your login query to add paramBinding
- Check that the SQL injection is not possible anymore
- Change all your code to handle parameters binding

---
# Exceptions
While we were working with SQL, we've used this kind of structure:
```php
<?php
try {
  // Some code
} catch (Exception $e) {
  // More code
}
?>
```
This kind of code is used with [Exceptions](http://php.net/manual/fr/language.exceptions.php) <!-- .element: target="_blank" -->

Exceptions are a way to handle error created by PHP, or even create your own errors!
--
# Exceptions
The whole idea is about throwing things around and catching them somewhere else!

Basically you throw Exceptions and you catch them:
```php
<?php
function iThrowStuff(){ throw new Exception("Youhou!");}
try {
  iThrowStuff();
} catch (Exception $e) {
  echo $e->getMessage(); // Display Youhou!
}
?>
```

--
# Exceptions

When an exception is thrown, **code following the statement will not be executed** and PHP will attempt to find the **first matching catch block**
```php
<?php
function iThrowStuff(){ throw new Exception("Youhou!");}
try {
  // Code here is executed
  iThrowStuff();
  // Code here is NOT executed
} catch (Exception $e) {
  echo $e->getMessage(); // Display Youhou!
}
?>
```

--
# finally
The `try/catch` structure could be empowered by the `finally` syntax
```php
<?php
function iThrowStuff(){ throw new Exception("Youhou!");}
try {
  // Code here is executed
  iThrowStuff();
  // Code here is NOT executed
} catch (Exception $e) {
  echo $e->getMessage(); // Display Youhou!
} finally {
  // Code here is ALWAYS executed
}
?>
```
The finally statement allow us to be sure, that in **both cases**, some code is executed

--
# Example
Sometimes you want to catch only some exceptions, as for SQL you can focus on catching SQL Errors:
```php
<?php
try{
  $conn->quey('SELECT * FROM users WHERE'. $someInput)->fetchAll(); // Activate exception
} catch (\PDOException $e){ // 
  $logger->log($e->getMessage());
} finally {
  $results = $conn->quey('SELECT * FROM users')->fetchAll(); // fallback
}
// Code here will be executed and results will be defined
?>
```

--
# the STFU operator
[The STFU operator](http://php.net/manual/fr/language.operators.errorcontrol.php) <!-- .element: target="_blank" -->

Only one thing to know:
> ## NEVER USE IT
--
# Exercices
Handle error cases when you make queries

---
# File architecture

--
# Include/Require
A little bit of semantic:
- [include](http://php.net/manual/en/function.include.php), tells PHP to include the content of a php file <!-- .element: target="_blank" -->
  - Throw a Warning if the file doesn't exist 
- [require](http://php.net/manual/en/function.require.php), same as include but there is a notion of requirement <!-- .element: target="_blank" -->
  - Throw a Critical error if the file doesn't exist 

Other forms `include_once` and `require_once` helps you avoid including multiple time the same file.

--
# Beware!
The include statement includes and **EVALUATES** the specified file.

There is an **evil `eval()`** function behind those statements

> Be very carefull of using variables with include/require

```php
<?php
  // define a var $path somewhere

  include $path;
  // If a user can control the content of path, 
  // this is a recipe for disaster 
?>
```

--
# Exercice
- Create multiple files and require them at the right place in your code and DRY your code!
  - session.php / header.php / footer.php
- Create a file functions.php and create some functions for:
  - DB
    - Create connect/query/loginHelper functions
  - String
    - Create DB/input sanitize functions
- Use Exceptions to improve error handling
- Refactor all our code!
