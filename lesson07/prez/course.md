# PHP / MySQL
## MySQL, Streams and PHAR

*Pre-requisites: lesson 6*

*ECV Digital - 25/11/2015*

---
## Transactions blocks
A Transaction block is a group of operations that are committed (or discarded) atomically, so that either all of them are applied to the database, or none.

> This ensures that any work performed during a transaction will be applied safely to the database when it is committed.

[PHP doc for Transactions](http://php.net/manual/fr/pdo.transactions.php) <!-- .element: target="_blank" -->

--
## Transactions blocks
A transaction start with a `START TRANSACTION` statement and should end with a `COMMIT` statement.
```mysql
START TRANSACTION; # Don't forget the ';'
UPDATE book SET id = id + 1;
DELETE FROM book_chapter WHERE isbn LIKE '0433%';
COMMIT;
```
Which gives in PHP

```php
<?php
  $dbh->beginTransaction();
  $dbh->exec("UPDATE book SET id = id + 1");
  $dbh->exec("DELETE FROM book_chapter WHERE isbn LIKE '0433%'");
  $dbh->commit();
?>
```

--
# Exercice
Use a transaction to update the database when you upload a picture.
- Use a try / catch statement
- Handle the error case


---
# Mysql joins
A MySQL **`joins`** statement combine data from multiple tables to create a single record set.

There are two basic types of joins: **`inner joins`** and **`outer joins`**. 

> In both cases, **`joins`** create a link between two tables based on a common set of columns (keys).

--
# Inner joins
An inner join returns rows from both tables only if keys from both tables can be found that satisfy the join conditions
```mysql
 SELECT * FROM users 
 INNER JOIN files ON files.id = users.file_id;
```
If the file_id columns can be null for example, this query will automatically clean the results for you.

--
# Outer joins
An outer joins return all records from one table while restricting the other table to matching records.
```mysql
  SELECT * FROM users 
  LEFT JOIN files ON files.id = users.file_id;
```
If the file_id columns can be null for example, this query will return all the joined table fields NULL.

--
# Exercice
When you load the user profile, use a join statement to get at the same time:
- The user information
- The user profile picture data

---
# Streams
The streams layer is an abstraction layer for file access.

In fact, when we accesssed the filesystem, we were using a stream implemtation.

Here is [all the wrapper](http://php.net/manual/en/wrappers.php) <!-- .element: target="_blank" --> we can use for different protocol

As you can see we can just use the C-like functions we were already using: `fopen, fread, ...`

--
# Network access
Accesing web page can be done easily:

```php
<?php
$f = fopen('http://php.net', 'r');
$page = '';
if ($f) {
  while ($s = fread($f, 1000)) { // This is a way in PHP, to receive a stream of information
    $page .= $s; 
  }
}
echo $page;
?>
```
This might not look like it, but this is already a very basic proxy in PHP.

--
# Stream Contexts
Stream contexts allow you to pass options to the stream handlers. For example, you can instruct the HTTP stream handler to perform a POST operation

Stream contexts are created using [**`stream_context_create()`**](http://php.net/manual/fr/function.stream-context-create.php) <!-- .element: target="_blank" -->

```php
<?php
$params = ['http' => [
  'method' => 'POST',
  'content' => 'var1=val1'
]];
$ctx = stream_context_create($params);
$fp = fopen('http://php.net/search.php', 'rb', false, $ctx);
?>
```

--
# Default context
We can also set a default context for all our next stream operation with 
[**`stream_context_set_default`**](http://php.net/manual/en/function.stream-context-set-default.php) <!-- .element: target="_blank" -->

```php
<?php
$params = ['http' => [
  'method' => 'POST',
  'content' => 'var1=val1'
]];
stream_context_set_default($params);
$fp = fopen('http://php.net/search.php', 'rb');
?>
```

Here is the complete list of [PHP stream functions](http://php.net/manual/en/book.stream.php) <!-- .element: target="_blank" -->

--
## Advanced Stream Functionality
If built-in stream handlers are not enough, you can create a socket server and a socket client using [**`stream_socket_server()`**](http://php.net/manual/en/function.stream-socket-server.php) <!-- .element: target="_blank" --> and [**`stream_socket_client()`**](http://php.net/manual/en/function.stream-socket-client.php) <!-- .element: target="_blank" -->

> You can access the tcp and udp protocol thanks to those functions.

--
# Exercice
In the users profile, implement a field which allow the user tu write an the url of an image
- Use stream handlers 
- Check if the file exists
- If it exists, download it.

---
# PHAR
> [PHAR = PHP Archive](http://php.net/manual/en/book.phar.php) <!-- .element: target="_blank" -->

[PHAR](http://php.net/manual/en/phar.fileformat.php) allows you to create and distribute entire PHP applications as a single file archive <!-- .element: target="_blank" -->

A PHP Archive (regardless of format) contains 3 parts:
1. [A stub](http://php.net/manual/en/phar.fileformat.stub.php) <!-- .element: target="_blank" -->
2. A manifest describing its contents
3. The file contents

--
# PHAR
All you need to create a PHAR file is:
- An "app" folder with all your files
- A build folder where you build the PHAR
- Your PHP entry point for the CLI ou the webserver

```php
<?php
$phar = new Phar("my/build/folder/myAppName.phar", 0, "app.phar");
$phar->buildFromDirectory("./myAppFolder");
$phar->setStub(
  $phar->createDefaultStub(
    "cli/entry.php", "public/entry.php"
));
?>
```
---
## Project: simple blog
Using ALL the knowledge so far, implement a very simple blogging system

Some guidelines are given on the next slides.
--
### Project: A post
A post can contain a title, a body and an image. It is linked to an author and is posted at a precise date.

- Create a table named posts with columns:
  - id, title, body, user_id, image_id, created_at

**Create it manually (be carefull about each field type)!**

--
## Project: user's area
- List all the user's posts in a very simple dashboard
- Create a page where the user can create new posts
- Create a page for editing existing post
- Add the capacity to delete a post

--
## Project: Refactor the homepage
- List posts ordered by date
- Create a pagination
- Display the author information on each listed post