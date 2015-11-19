# PHP / MySQL
## Introduction to PHP and GIT
*ECV Digital - 15/10/2015*

**Pre-requisites: you must read the Readme placed at the root folder to setup your computer**

---
# Welcome 
## The teacher: Morgan Giraud
![Morgan Giraud](https://en.gravatar.com/userimage/27393472/35e00906a5a12cd6a66616944e8d5edf.png?size=200)

[Linkedin](https://fr.linkedin.com/in/morgangiraud) <!-- .element: target="_blank" -->
[Github](https://github.com/morgangiraud) <!-- .element: target="_blank" -->

---
#Tools
Tool that will be used in this course:
- [Sublime Text 3](http://www.sublimetext.com/3) <!-- .element: target="_blank" -->
- [Git](https://git-scm.com/) <!-- .element: target="_blank" -->
- [PHP >5.5](http://www.php.net/) <!-- .element: target="_blank" -->
- [Nginx](http://nginx.org/) <!-- .element: target="_blank" -->

--
# GIT
- GIT Installation: See the README
- Introduction [tutorial](https://try.github.io/) <!-- .element: target="_blank" -->
- Training on http://pcottle.github.io/learnGitBranching <!-- .element: target="_blank" -->
    - Exercice 1-4, normal mode 
    - Exercice 1-6, remote mode

---
# PHP
###### A little Instroduction to PHP
- [Wikipedia](https://en.wikipedia.org/wiki/PHP) <!-- .element: target="_blank" -->
- Check the RESOURCES.md file for more resources

--
## Configuration
PHP Works with a huge config file, usually call `php.ini`. This file can be different for the PHP CLI (Command Line Interface) and PHP used by the webserver.

To locate the file for the CLI you can do:
```bash
# Locating the config file
php --ini
# You can also access all the current configuration
php -i
# And greping for a special information
php -i | grep error
```

--
## Configuration
To locate the file for the webserver you can create a PHP file containing (`phpinfo.php`):
```php
<?php
phpinfo();
?>
```
And access it from the browser.

--
# Error config
Before starting developping, let's check if we have the good PHP configuration to display errors:

- Locate the php.ini used by the webserver
- Edit it and check that:
  - error_reporting = E_ALL
  - display_errors = On
  - display_startup_errors = On
  - log_errors = On
- Save the file, and restart you php process if any (You can check with this command: `ps -e | grep php`)

---
# Course objectif
[Zend Certification](http://www.zend.com/en/services/certification/php-5-certification) <!-- .element: target="_blank" -->

Overview of all the subject that will be studied in this course:
   - PHP Basics (Focus on Namespaces and extensions) <!-- .element: class="fragment" -->
   - Arrays (Focus on array functions) <!-- .element: class="fragment" -->
   - Functions (Focus on closure and Anonymous functions) <!-- .element: class="fragment" -->
   - Web Features (Focus on Globals and Session) <!-- .element: class="fragment" -->
   - Security (Focus on injections) <!-- .element: class="fragment" -->
   - I/O with the FileSystem (Focus on file and Streams) <!-- .element: class="fragment" -->
   - Database (MySQL) <!-- .element: class="fragment" -->
   - Not in this course: <!-- .element: class="fragment" --> ~~OOP~~

--
# Homework
- Finish level 2 of **normal mode** and level 1 of remote mode on the [training](http://pcottle.github.io/learnGitBranching) <!-- .element: target="_blank" -->
Read all the following subjects in the first hundreds page of the zend certification guide

Note: All the students have the Zend certification guide