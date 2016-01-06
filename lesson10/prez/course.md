# PHP / MySQL
## Strings & Patterns

*Pre-requisites: lesson 9*

*ECV Digital - 06/01/2016*

---
# String Basics

2 kind of strings in PHP:
- Simple string: almost all characters are used literally
- Complex string: allow for special escape sequences (string interpolation)
```php
<?php
// Simple string
echo '\x2a'; // → \x2a
// Complex string
echo "\x2a"; // → *
$who = "World";
echo "Hello $who"; // → Hello World
?>
```

--
## String interpolation
If you need to interpolate more complex structure, you can use `{}` to encapsulate data.

```php
<?php
// Accessing an array
$names = array('Smith', 'Jones', 'Jackson');
echo "Hi, i'm mr {$names[1]}"; // → Hi, i'm mr Jones

//Concatening a variable's name and some text
$name = "apple";
echo "There is 5 {$name}s"; // → There is 5 apples
?>
```

--
## Heredoc
Heredoc is another way to declare complex strings, allowing us to write multiple lines and define a custom string delimiter

It is defined by the special delimiter: `<<<`
```php
<?php
$who = "World";
echo <<<WHATEVER
I said: "Hello $who"
WHATEVER;
// → I said: "Hello World" 
// Notice the double quotes in the output
?>
```

--
## Nowdoc
Nowdoc is the equivalent simple string, just add some `'` around the custom string delimiter
```php
<?php
$who = "World";
// Notice the simple quotes
echo <<<'WHATEVER'
I said: "Hello $who"
WHATEVER;
// → I said: "Hello $who" 
?>
```

--
## Escaping
In any type of string, there is at least one character which is considered as a special value.

In a simple string: you can't write a `'` until you **escape** it.

Escaping is done thanks to the special character: `\`
```php
<?php
echo 'Escaping those \'\' characters'; // → Escaping those '' characters
echo 'Writing a \\ character'; // → Writing a \ character
?>
```

More information [here](http://php.net/manual/en/language.types.string.php) <!-- .element: target="_blank" -->

---
## Use strings as arrays
You can access characters in a string as you would with an array
```php
<?php
$str = 'abcdef';
echo $str[1]; // → 'b'
// indexes are zero-based
?>
```
The [strlen](http://php.net/manual/en/function.strlen.php) <!-- .element: target="_blank" --> function allows you to count the number of character of a string (You can't use the `count` function)

--
## Comparing strings
Especially with strings, never use the `==` operator
```php
<?php
$str = '123aa';
if ($str == 123) { // PHP cast the string as an integer before comparing it
    echo "true";
}
// → true
?>
```

To compare strings always use the `===` operator or [strcmp](http://php.net/manual/en/function.strcmp.php)<!-- .element: target="_blank" --> and [strcasecmp](http://php.net/manual/en/function.strcasecmp.php)<!-- .element: target="_blank" --> functions

--
# Searching a string
You can search a string uing the [strpos](http://php.net/manual/en/function.strpos.php) <!-- .element: target="_blank" --> function or its variation: [strstr](http://php.net/manual/en/function.strstr.php) <!-- .element: target="_blank" -->

The [strstr](http://php.net/manual/en/function.strstr.php) <!-- .element: target="_blank" --> function returns the portion of the haystack that starts with the needle instead of an integer (it is slower).

```php
<?php
$haystack = "abcdefg";
$needle = 'abc';
if (strpos($haystack, $needle) !== false) {
  echo 'Found';
}
echo strstr($haystack, $needle); // → abcdefg
?>
```

**Those functions are case sensitive and search from the beginning of the string**

--
# Searching a string
There are also **case-insensitive** functions:
- [stripos](http://php.net/manual/en/function.stripos.php) <!-- .element: target="_blank" -->
- [stristr](http://php.net/manual/en/function.stristr.php) <!-- .element: target="_blank" -->

Or reverse functions:
- [strrpos](http://php.net/manual/en/function.strrpos.php) <!-- .element: target="_blank" -->
- [strrstr](http://php.net/manual/en/function.strrstr.php) <!-- .element: target="_blank" -->

--
# Replacing Strings
There are multiple functions to replace part of strings:
- [strtr](http://php.net/manual/en/function.strtr.php) <!-- .element: target="_blank" -->

```php
<?php
// Replace a single character
echo strtr('abc', 'a', '1'); // → 1bc

// Replace multiple characters
$subst = array('1' => 'one', '2' => 'two',);
echo strtr('123', $subst); // → onetwo3
?>
```

--
# Replacing Strings
- [str_replace](http://php.net/manual/en/function.str_replace.php) <!-- .element: target="_blank" -->
- [str_ireplace](http://php.net/manual/en/function.str_ireplace.php) <!-- .element: target="_blank" -->

```php
<?php
echo str_replace("World", "Dude", "Hello World"); // → Hello Dude
echo str_ireplace("world", "dude", "Hello World"); // → Hello dude

echo str_replace(array("Hello","World"), "Dude", "Hello World"); // → Dude Dude
?>
```

--
# Extracting strings
the [substr](http://php.net/manual/en/function.substr.php) <!-- .element: target="_blank" --> function allows you to extract a substring from a larger string. 
```php
<?php
  $x = '1234567';
  echo substr($x, 0, 3); // → 123
  echo substr($x, 1, 1); // → 2
  echo substr($x, -2); // → 67
  echo substr($x, 1); // → 234567
  echo substr($x, -2, 1); // → 6
?>
```

---
## Formatting Strings
Concatenating strings can be tricky with dynamic typing. 

For a full control, you need to format your string.

PHP allows you to do that thanks to the [sprintf](http://php.net/manual/en/function.sprintf.php) <!-- .element: target="_blank" --> function

```php
<?php
  $n = 123;
  $f = 123.45;
  $s = "A string";
  printf("%d", $n); // → 123
  printf("%d", $f); // → 123
  printf("The string is %s", $s); // → The string is A string
  printf("%3.3f", $f); // → 450
?>
```
 
--
## Formatting Strings
As [sprintf](http://php.net/manual/en/function.sprintf.php) <!-- .element: target="_blank" --> , [sscanf](http://php.net/manual/en/function.sscanf.php) <!-- .element: target="_blank" -->  allows one to parse formatted input.
```php
<?php
$data = '123 456 789';
$format = '%d %d %d';
var_dump(sscanf($data, $format)); 
// → array(3) { [0]=> int(123) [1]=> int(456) [2]=> int(789) }
?>
```
**data must match the format passed to sscanf() exactly, or
the function will fail to retrieve all the values** 

For this reason, it is only useful when input follows a well-defined format (that is, NOT provided by the user!).

---
# PCRE
Perl Compatible Regular Expressions

[PCRE](http://php.net/manual/en/book.pcre.php)<!-- .element: target="_blank" --> offer a very powerful string-matching and replacement mechanism.
- It is always delimited by a starting and ending character ([delimiter](http://php.net/manual/en/regexp.reference.delimiters.php)<!-- .element: target="_blank" -->).
- It is compose of [metacharacters](http://php.net/manual/en/regexp.reference.meta.php) <!-- .element: target="_blank" --> 
- It can contains [modifiers](http://php.net/manual/en/reference.pcre.pattern.modifiers.php)<!-- .element: target="_blank" --> 

RegExp can contains sub expressions and much more

--
## Using PCRE

PHP provides a set a [functions](http://php.net/manual/en/ref.pcre.php)<!-- .element: target="_blank" -->  to handle PCRE.
They are all prefixed with the `preg_` statement for **Perl REGular expression**

Here is an example with the [preg_match()](http://php.net/manual/en/function.preg-match.php) <!-- .element: target="_blank" -->function 

```php
<?php
$name = "Hip Hop";
$regex = "/[a-zA-Z\s]/"; // Simple match
if (preg_match($regex, $name)) { 
    // Valid Name
}
$regex = '/^(\w+)\s(\w+)/'; // Match with subpatterns and capture
$matches = array();
if (preg_match($regex, $name, $matches)) {
    var_dump($matches);
    // → array(3) { [0]=> "Hip Hop" [1]=> "Hip" [2]=> "Hop" }
}
?>
```

--
## Using PCRE
You can also name your matches
```php
<?php
$name = "Hip Hop";
$regex = '/^(?<match1>\w+)\s(?<match2>\w+)/';
$matches = array();
if (preg_match($regex, $name, $matches)) {
    var_dump($matches);
    // → array(3){ [0]=>"Hip Hop" match1=>"Hip" [1]=>"Hip" match2=>"Hop" [2]=>"Hop" }
}
?>
```
--
## Using PCRE to replace

As [str_replace](http://php.net/manual/en/function.str_replace.php) <!-- .element: target="_blank" --> you can use - [preg_replace](http://php.net/manual/en/function.preg_replace.php) <!-- .element: target="_blank" --> to replace part of a string using RegExp

```php
<?php
$data = "all right dudes";
$regex = "@^(.*?)$@";
$replacement = '<p>$1</p>'; // $1 means the first match
echo preg_replace($regex, $replacement, $data); 
// → <p>all right dudes</p>
?>
``` 
--
## Exercices
Train yourself on this [website](http://regexone.com/)<!-- .element: target="_blank" --> (Follow exactly the rules)

Here is a very usefull tool to [analyse your regex](https://regex101.com/) <!-- .element: target="_blank" -->