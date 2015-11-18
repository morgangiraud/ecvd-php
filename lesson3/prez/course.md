# PHP / MySQL
## Filesystem, hashing and headers
*ECV Digital - 29/10/2015*

**Pre-requisites: lesson 2**

--- 
# GIT time
Before each course you must check and sync. your git repo
1. Move to your own repo: `mv my-folder/`
2. Check the current state of your repo: `git status`
2. Pull the `origin master` branch to sync with your repo: `git pull` (alias for `git pull origin master`)
3. Pull the `upstream master` branch to get in sync with the teacher's repo: `git pull upstream master`

> [Memoize](https://en.wikipedia.org/wiki/Memoization)<!-- .element: target="_blank" -->! we need to speed up the load of each course

---
# FileSystem
Let's have a look at all the PHP [filesystem functions](http://php.net/manual/en/book.filesystem.php) <!-- .element: target="_blank" -->

File handle based functions:
```
file_exists, fstat
fopen
fread/fgets, fseek, ftell, ftruncate, fwrite/fputs, feof
fclose
```

Memory agressive ones: 
```
file_get_contents, file_put_contents
```

--
# Resources battle

Memory friendly:
> They works with a file handle, so they don't have to load the entire file into memory but 
they to make more I/O calls

Example: `fopen, fread/fgets, fclose`

Very usefull to be able to work with **HUGE** file

--
# Resources battle
Processing power friendly:
> They don't keep any file handle, they do all the work one shot

Very usefull to simplify the loading of small files. 

**Deadly** if the file gets too big for the PHP script memory_limit.

--
# Exercice
Change the login.php script to load users from a file and handle both cases depending on the size of the file
- [Access the value of memory_limit](http://php.net/manual/en/function.ini-get.php) <!-- .element: target="_blank" -->
- Compare it to the [file size](http://php.net/manual/en/function.preg-match.php) <!-- .element: target="_blank" -->
- If it's two time smaller, load it completly
- if not use file handers

---
# Security
Everytime you ask a user for any kind of input, those informations must be:
> **[SANITIZED!](http://php.net/manual/en/ref.filter.php)** <!-- .element: target="_blank" -->
> Never trust any client-side information

Basic string cleaning 
> `trim, htmlspecialchars ...`

--
# Hashing
Usefull for
> 
- Security (password)
- Obfuscation (hide ids)
- Integrity/Data tranfer (image)

Best practice:
> 
- The password [API](http://php.net/manual/en/ref.password.php) <!-- .element: target="_blank" -->
- And its [Algorithms](http://php.net/manual/en/password.constants.php) <!-- .element: target="_blank" -->
- A list of php [hash functions](http://php.net/manual/en/ref.hash.php) <!-- .element: target="_blank" -->

--
# Exercice
Secure your app:
- Encode passwords with a strong algorithm

---
#Headers
> 
- Redirection
- Content-type
- Caching directive
- Compression indication
- Lang

Headers are in all HTTP call: request and response

Look at the network section in your browser console and check both header from the request and the response
--
#Headers: PHP
[`header('header-key:header-value');`](http://php.net/manual/fr/function.header.php) <!-- .element: target="_blank" -->

Comme pour les sessions, les `headers` doivent être en première ligne
```
<html> <!-- From PHP Point of view, this is already an output  -->
<?php
/* This will show an error. Motice the upper output which
 * is before the header function call */
header('Location: http://www.example.com/');
exit;
?>
```
More [info](http://stackoverflow.com/questions/8028957/how-to-fix-headers-already-sent-error-in-php)

Special case of [redirection](http://stackoverflow.com/questions/23993207/php-which-is-the-best-practise-of-header-location)

--
# Status Code
Here is the [full list of HTTP status code](https://en.wikipedia.org/wiki/List_of_HTTP_status_codes) <!-- .element: target="_blank" -->

The more important:
- 1xx Informational
- 2xx Success
- 3xx Redirection
- 4xx Client Error
- 5xx Serve Error

--- 
# Year Project
Company:
>[Good planet](http://www.goodplanet.org/) <!-- .element: target="_blank" -->

Project:
> Build a website usable by children. There must be student and teachers account, student can create small page from drag and drop UI and templates. Teachers can validate them and publish them.
