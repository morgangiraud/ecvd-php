# PHP / MySQL
## NameSpace, File Upload and Improved filtering

*Pre-requisites: lesson 5*

*ECV Digital - 19/11/2015*

---
# Namespace
namespaces is a way to encapsulate code. It naming collisions and the need to alias long names.

Only classes, traits, interfaces, functions, and constants are affected by them.

- declare it using the namespace keyword
- The namespace must be declared at the top of the file
- It may only be preceded by the opening PHP tag and a declare statement.

--
# Namespace
Declaring namespace
```php
<?php
namespace Ns;

// Code here is within the namespace
?>
```

You can declare multiple (sub-)Namespace in one file

```php
<?php
namespace Ns {
  // Code here is within the namespace
};
namespace Sub\Ns {
  // Code here is within the namespace
};
?>
```
--
# Using namespaces
Declare a function in a namespace
```
<?php
namespace Ns;

function hello(){
  echo "hello world";
}
?>
```
Use it somewhere else
```
<?php
Ns\hello(); // → hello world
?>
```
--
# Root Scope
There is a root Scope in PHP, where all the native functions are. 
Those can be access even in a Namespace:
- Global function ad constants fallbacks to the root scope when you use it
- You can prefix the function call with the delimiter `\`
```php
<?php
Namespace Ns;
echo "hop"; // fallback to the root scope echo function
\echo "hop" // Same as the first call
?>
```
Best practice: In a Namespace, always fully qualified global functions, classes etc.
--
Exercice
- Move all the functions in the function.php file inside the Namespace Ecvdphp
- Refactor your code

---
# Forms
Forms and POST data have 3 different encryption type:
- application/x-www-form-urlencoded (default)
- multipart/form-data
- text/plain

More insight [here](http://stackoverflow.com/questions/4526273/what-does-enctype-multipart-form-data-mean) <!-- .element: target="_blank" -->

--
## Forms: File Upload
To upload a file, you need to be able to send data in a binary mode.

The enctype `multipart/form-data` allows entire files to be included in the data.

```html
<form enctype="multipart/form-data" action="index.php" method="post">
  <input name="filedata" type="file" />
  <input type="submit" value="Send file" />
</form>
```
> It actually render this :
<form enctype="multipart/form-data" action="index.php" method="post">
  <input name="filedata" type="file" />
  <input type="submit" value="Send file" />
</form>

--
## Forms: File Upload
Once a file is uploaded to the server, PHP stores it in a **temporary location** and makes it available to the script that was called by the POST transaction

It is up to the script to move the file to a safe location. 

> the temporary copy is automatically destroyed when the script ends

--
## Forms: File Upload

You can access your files on the PHP side thanks to the [`$_FILES` superglobal](http://php.net/manual/fr/features.file-upload.post-method.php) <!-- .element: target="_blank" -->
```html
<form enctype="multipart/form-data" action="index.php" method="post">
  <input name="filedata" type="file" />
  <input type="submit" value="Send file" />
</form>
```

```php
<?php
echo $_FILES['filedata']['name'];
?>
```
--
# Exercice
Implement a file upload system to add a picture to the user profile
- Add a table `file` int he DB with columns id, filename, path, extension
- Add a form to handle file Upload
- Implement the PHP 
- Secure your script using error, size and the function `is_uploaded_file()`, check the extension

---
# FIEO
The golden rule of security in program

> Filter Input, Escape Ouput

if the data originates from a foreign source, such as user form input, a query string, or even an RSS feed, it cannot be trusted

The data in **all of PHP’s superglobal (but $_SESSION)** arrays should be considered harmfull

--
# Filter input
Before processing data, it is important to filter it: the data is only safe to use once it is filtered.

> You must validate it

You can use [ctype_* functions](http://php.net/manual/fr/book.ctype.php) <!-- .element: target="_blank" --> or [infammous regex](http://php.net/manual/fr/book.pcre.php) <!-- .element: target="_blank" --> or even check agains hardcoded possiblity
```php
<?php
if (ctype_alpha($_POST['username'])) { /* OK */}
if (preg_match("/\d+/", $_POST['age'])) { /* OK */}
$genders = array('male', 'female', 'other'));
if (in_array($_POST['gender']), $genders) { /* OK */}
?>
```

--
# Escape output
Escaping output protects the client and user from potentially damaging commands.

Output must be escaped because clients often take action when encountering special characters:
> 
- Browsers: HTML tags
- DB: quotation marks and SQL keywords

Of course escaping html tags for your database is quite useless, therefore you should always be aware of the destination of your output.
-- 
# Escape output
- For html use the **`htmlentities`** function
- For your DB always use the **PDO object and prepare statement**

--
# Advanced filtering
You can use  the [filter extension](http://php.net/manual/fr/book.filter.php) <!-- .element: target="_blank" --> 
- The [`filter_input`](http://php.net/manual/fr/function.filter-input.php) function <!-- .element: target="_blank" --> 
- The [`filter_var`](http://php.net/manual/fr/function.filter-var.php) function <!-- .element: target="_blank" --> 

--
# Exercice
- Filter all your input
- Escape all your output