# PHP / MySQL
## A focus on arrays

*Pre-requisites: lesson 8*

*ECV Digital - 10/12/2015*

---
## Arrays
PHP arrays are flexible: they 
- have numeric auto-incremented keys 
- can have alphanumeric keys of arbitrary length. 
- can store any value, including other arrays. 

All arrays are ordered collections of value identified by a key that is unique to the array it belongs to. 

```php
<?php
  $a = array(10, 20, 30); // Specify only the values
  $a = array('a' => 10, 'b' => 20, 'cee' => 30); // Specify both keys and values
  $a = array(5 => 1, 3 => 2, 1 => 3,); // PHP ignore final comma
  $a = array(); // Empty array
  $a = [1, 'a']; // Usign the shorthand array syntax (faster)
?> 
```

--
## Arrays
Accessing arrays is done with the array operator ([]):

```php
<?php
$x[] = 10; // Add a new value to the array stored in the x var
//In this case, if x is undefined, PHP will automatically creates an array

$x['aa'] = 11; // Set a specific key
echo $x[0]; // Access the array
?>
```

In PHP, all arrays are associative, see [this well explained SO answer](http://stackoverflow.com/questions/5931206/are-numeric-and-associative-arrays-in-php-two-different-things) <!-- .element: target="_blank" -->

--
## Arrays: adding keys
When an element is added to an array without specifying a key, PHP automatically assigns a numeric one that is equal to the greatest numeric key in the array, plus one

```php
<?php
  $a = array(2 => 5);
  $a[] = 'a';
  var_dump($a); // → array(2) { [2]=> int(5) [3]=> string(1) "a" }
?>
```

Note that this is true even if the array contains a mix of numerical and string keys.

```
<?php
  $a = array('4' => 5, 'a' => 'b');
  $a[] = 44; // This will have a key of 5
  var_dump($a); // → array(3) { [4]=> int(5) ["a"]=> string(1) "b" [5]=> int(44) }
?>
```

--
## Arrays: more on keys
Keys are **case-sensitive**, but **type insensitive**
- The key **`'A'`** is different from the key **`'a'`**
- The keys **`'1'`** and **`1`** are the same. 
- The key **`'01'`** is not the same as the key **`1`**

Other types conversion:
- Float number are converted to integer **`12,5 -> 12`**
- Booleans are converted to integer **`false -> 0`** and **`true -> 1`** 
- **`NULL`** is converted to the empty string **`""`**
- You can't use arrays and objects as keys
  
--
## Multi-dimensional Arrays
Since every element of an array can contain any type of data, we can assign an array as the value for an array element.

An infinite level os nesting is allowed (limited by memory of course):

```php
<?php
  $b = array(
    array( 'foo', 'bar' )
  );
  $b[] = array( 'baz', 'bat' );
  echo $b[0][1] . $b[1][0]; // → barbaz
?>
```

--
## Array destructuring

PHP provides a quick shortcut to extract information from an array, the [`list()` construct](http://php.net/manual/en/function.list.php) <!-- .element: target="_blank" -->

```php
<?php
  $info = array('coffee', 'brown', 'caffeine');
  list($drink, $color, $power) = $info; // We assign three vars
  echo "$drink is $color and $power makes it special.\n";
  // → coffe is brown and caffeine makes it special.
?>
```

---
## Array operations and functions
PHP provides a few native [array functions](http://php.net/manual/en/ref.array.php) <!-- .element: target="_blank" --> and [operations](http://php.net/manual/en/language.operators.array.php) <!-- .element: target="_blank" -->

The **`+`** operator can be used to create the union of 2 arrays

```php
<?php
  $a = array(1, 2);
  $b = array('c' => 3);
  var_dump($a + $b); // → array(3) { [0]=> int(1) [1]=> int(2) ["c"]=> int(3) }
?>
```

 If the two arrays had common keys, they would only appear once in the end result:

```php
<?php
  $a = array(1, 2, 3);
  $b = array('a' => 1, '1' => 'b', 'c');
  var_dump($a + $b); // → array(4) { [0]=> int(1) [1]=> int(2) [2]=> int(3) ["a"]=> int(1) }
?>
```

--
## Comparing Arrays
Array-to-array comparison:
- The equivalence operator **`==`** returns true if both arrays have the same number of elements with the same values and keys, regardless of their order
- The identity operator **`===`**, returns true only if the array contains the same key/value pairs in the same order

```php
<?php
  $a = array(1, 2, 3);
  $b = array(1 => 2, 2 => 3, 0 => 1);
  $c = array('a' => 1, 'b' => 2, 'c' => 3);
  var_dump($a == $b); // → True
  var_dump($a === $b); // → False
  var_dump($a == $c); // → False
  var_dump($a === $c); // → False
  var_dump($a != $b); // → False
  var_dump($a !== $b); // → True
?>
```

--
## Counting
The size of an array can be retrieved by calling the [count()](http://php.net/manual/en/function.count.php) function  <!-- .element: target="_blank" -->

Count returns `1` if the parameter is not an arrat/Countable type

```php
<?php
  $a = array(1, 2, 4);
  $b = array();
  $c = 10;
  echo count($a); // → 3
  echo count($b); // → 0
  echo count($c); // → 1
?>
```

--
## Searching for keys
You can use the `isset()`function to check if a key exist but a key with value 'NULL' is considered inexistent.

The correct way to determine whether an array element exists is to use the [`array_key_exists()`](http://php.net/manual/en/function.array-key-exists.php) function  <!-- .element: target="_blank" -->
```php
<?php
  $a = array('a' => 1, 'b' => 2, 'd' => NULL);
  var_dump(isset($a['a'])); // → True
  var_dump(isset($a['c'])); // → False
  var_dump(isset($a['d'])); // → False !!!

  var_dump(array_key_exists('a', $a)); // → True
  var_dump(array_key_exists('d', $a)); // → True 
?>
```

-- 
## Searching for values
To search a value in an array, you must use the `in_array` function
```php
<?php
  $a = array('a' => NULL, 'b' => 2);
  var_dump(in_array(2, $a)); // True
?>
```

--
## Deleting keys

To delete an item, use the [`unset`](http://php.net/manual/en/function.unset.php) function  <!-- .element: target="_blank" -->
```php
<?php
  $a = array('a' => NULL, 'b' => 2);
  unset($a['b']);
  var_dump($a); // False
?>
```

--
## Flipping and Reversing
the [`array_flip()`](http://php.net/manual/en/function.array-flip.php) function <!-- .element: target="_blank" --> swaps the value of each element of an array with its key
```php
<?php
  $a = array('a', 'b', 'c');
  var_dump(array_flip($a)); // → array(3) { ["a"]=> int(0) ["b"]=> int(1) ["c"]=> int(2) }
?>
```

The [`array_reverse()`](http://php.net/manual/en/function.array-reverse.php) function <!-- .element: target="_blank" --> reverses the order of the array’s elements

```php
<?php
  $a = array('x' => 'a', 10 => 'b', 'c');
  var_dump(array_reverse($a)); // → array(3) { [0]=> string(1) "c" [1]=> string(1) "b" ["x"]=> string(1) "a" }
?>
```

**Be carefull, numeric keys will be lost**

---
## The Array Pointer
Arrays have a pointer that indicates the “current” element

The pointer does not affect nor is affected by array operations

The pointer maintains the iterative state of an array without needing an external variable

```php
<?php
  $array = array('foo' => 'bar', 'baz', 'bat' => 2);
  function displayArray(&$array) {
    reset($array);
    while (key($array) !== null) {
        echo key($array) . ": " . current($array) . PHP_EOL;
        next($array);
    } 
  }
?>
```
--
## The Array Pointer
The list of pointer functions:
- [`reset()`](http://php.net/manual/en/function.reset.php) set the current pointer to the first element <!-- .element: target="_blank" -->
- [`end()`](http://php.net/manual/en/function.end.php) set the current pointer to the last element <!-- .element: target="_blank" -->
- [`next()`](http://php.net/manual/en/function.next.php) move forward <!-- .element: target="_blank" -->
- [`prev()`](http://php.net/manual/en/function.prev.php) move backward <!-- .element: target="_blank" -->
- [`current()`](http://php.net/manual/en/function.current.php) access the current value <!-- .element: target="_blank" -->
- [`key()`](http://php.net/manual/en/function.key.php) access the current key <!-- .element: target="_blank" -->

--
## Foreach 
The [`foreach()`](http://php.net/manual/en/control-structures.foreach.php) <!-- .element: target="_blank" --> construct iterate through the entire array from start to finish
```php
<?php
  $array = array('foo', 'bar', 'baz');
  foreach ($array as $key => $value) {
    echo "$key: $value" . PHP_EOL;
  }
?>
```

--
## Foreach 
`foreach()` operates on a copy of the array itself: changes made to the array inside the loop are **NOT** reflected in the iteration

Unless you use a reference
```php
<?php
  $a = array(1, 2, 3);
  foreach ($a as $k => &$v) {
    $v += 1;
  }
  var_dump($a); // → $a will contain (2, 3, 4)
?>
```

-- 
## Foreach 
But you should **NOT** use the reference trick, see the following

```php
<?php
  $a = array('zero', 'one', 'two');
  foreach ($a as &$v) {}
  foreach ($a as $v) {}
  print_r($a); // → Array ( [0] => 'zero' [1] => 'one' [2] => 'one' )
?>
```

Why the array has been updated ?

Before the second for loop $v is already defined by reference, any new value attributed to it will update the array accordingly...

--
## Array walk

The [`array_walk()`](http://php.net/manual/en/function.array-walk.php) <!-- .element: target="_blank" --> function and its recursive version [`array_walk_recursive()`](http://php.net/manual/en/function.array-walk-recursive.php)<!-- .element: target="_blank" --> are used to perform an iteration of an array in which a user-defined function is called.

```php
<?php
function upperCase(&$value, &$key) { $value = strtoupper($value); }
$type = array('internal', 'custom');
array_walk($type, 'upperCase');
var_dump($type);
?>
```

---
## Sorting by values
The [`sort()`](http://php.net/manual/en/function.sort.php) function  <!-- .element: target="_blank" --> and [`rsort()`](http://php.net/manual/en/function.rsort.php) <!-- .element: target="_blank" --> functions sorts an array from lowest to highest and from highest to lowest respectively based on its values

[`sort()`](http://php.net/manual/en/function.sort.php) <!-- .element: target="_blank" --> modifies the provided array, destroys all the keys and renumbers its elements starting from zero

```php
<?php
  $array = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
  asort($array);
  var_dump($array); // → array(3) { ["b"]=> "bar" ["c"]=> "baz" ["a"]=> "foo" }
?>
```

--
## Sorting by values
To maintain key association, you can use the [`asort()`](http://php.net/manual/en/function.asort.php) function  <!-- .element: target="_blank" -->
```php
<?php
  $array = array('a' => 'foo', 'b' => 'bar', 'c' => 'baz');
  asort($array);
  var_dump($array); // → array(3) { ["b"]=> "bar" ["c"]=> "baz" ["a"]=> "foo" }
?>
```

Both [`sort()`]() and [`asort()`](http://php.net/manual/en/function.asort.php) <!-- .element: target="_blank" --> accept a second, optional parameter that allows you to specify how the sort operation takes place

--
## Sorting by keys
The [`ksort()`]() and [`krsort()`](http://php.net/manual/en/function.krsort.php) <!-- .element: target="_blank" --> functions sorts an array based on its keys
```php
<?php
  $a = array('d' => 30, 'b' => 10, 'c' => 22);
  ksort($a);
  var_dump($a); // → array(3) { ["b"]=> int(10) ["c"]=> int(22) ["d"]=> int(30) }
?>
```
 
--
## Custom sorting
The `usort` function allows you to sort an array by providing a user-defined function

```php
<?php
function myCmp($left, $right) {
  $diff = strlen($left) - strlen($right);
  if (!$diff) {
    return strcmp($left, $right);
  }
  return $diff;
}
$a = ['three', '2two', 'one', 'two'];
usort($a, 'myCmp');
var_dump($a); // → array(4) { [0]=> "one" [1]=> "two" [2]=> "2two" [3]=> "three" }
?>
```
 
--
## Shuffling
The [`shuffle()`](http://php.net/manual/en/function.shuffle.php) <!-- .element: target="_blank" --> function allows you to shuffle an array, the key-value association will be lost thought.

```php
<?php
  $cards = array(1, 2, 3, 4);
  shuffle($cards);
  var_dump($cards); // → array(4) { [0]=> int(4) [1]=> int(1) [2]=> int(2) [3]=> int(3) }
?>
```

Here is a little trick to access an in a radom order
```php
<?php
  $cards = array('a' => 10, 'b' => 12, 'c' => 13);
  $keys = array_keys($cards);
  shuffle($keys);
  foreach ($keys as $v) { ... }
?>
```         

--  
## Extract random value
The [`array_rand()`](http://php.net/manual/en/function.array-rand.php) <!-- .element: target="_blank" --> function extract individual elements from the array at random, you can use array_rand(), which returns one or more random keys from an array

Extracting the keys from the array does not remove the corresponding element from it
```php
<?php
  $cards = array('a' => 10, 'b' => 12, 'c' => 13);
  $keys = array_rand($cards, 2);
  var_dump($keys); // → array(2) { [0]=> "a" [1]=> "b" }
  var_dump($cards); // → array(3) { ["a"]=> int(10) ["b"]=> int(12) ["c"]=> int(13) }
?>
```  

---
## Arrays as Stacks and Queues
A Stack is a data structure following the LIFO concept: Last In, First Out

A Queue is a data structure following the FIFO concept: First In, First Out

PHP provides 4 helpers to simulate those behavior

--
## Arrays as Stacks and Queues
The [`array_push()`](http://php.net/manual/en/function.array-push.php) function  <!-- .element: target="_blank" --> add elements at the end of an array

```php
<?php
  $stack = array();
  array_push($stack, 'bar', 'baz');
  var_dump($stack); // → array(2) { [0]=> "bar" [1]=> "baz" } 
?>
```

Unless you want to add multiple elements, the following is equivalent and faster
```php
<?php
  $stack = array();
  $stack[] = 'bar';
  $stack[] = 'baz';
  var_dump($stack); // → array(2) { [0]=> "bar" [1]=> "baz" } 
?>
```

--
## Arrays as Stacks and Queues
The [`array_pop()`](http://php.net/manual/en/function.array-pop.php) function  <!-- .element: target="_blank" --> remove elements at the end of an array
```php
<?php
  $stack = array('bar', 'baz');
  $last_in = array_pop($stack);
  var_dump($last_in, $stack); // → 'baz' , array(1) { [0]=> "bar }
?>
```

--
## Arrays as Stacks and Queues
The [`array_unshift()`](http://php.net/manual/en/function.array-unshift.php) function  <!-- .element: target="_blank" --> add elements at the beginning of the array
```php
<?php
  $stack = array('bar', 'baz');
  array_unshift($stack, 'foo');
  var_dump($stack); // → array(3) { [0]=> "foo" [1]=> "bar" [2]=> "baz" }
?>
```

--
## Arrays as Stacks and Queues
The [`array_shift()`](http://php.net/manual/en/function.array-shift.php) function  <!-- .element: target="_blank" --> remove elements at the beginning of the array
```php
<?php
  $stack = array('qux', 'bar', 'baz');
  $first_element = array_shift($stack);
  var_dump($stack); // → array(2) { [0]=> "bar" [1]=> "baz" }
?>
```

---
## Set Functionality
The [`array_diff()`](http://php.net/manual/en/function.array-diff.php) function  <!-- .element: target="_blank" --> compute the difference between two (or more) arrays and returns the values in the first array that are not present in any of the other arrays

```php
<?php
  $a = array(1, 2, 3);
  $b = array(1, 3, 4);
  var_dump(array_diff($a, $b)); // → array(1) { [1]=> int(2) }
?>
```

Variation:
- `array_diff_key()` computed on keys alone
- `array_diff_ukey()` with user-defined callback

--
## Set Functionality
The [`array_intersect()`](http://php.net/manual/en/function.array-intersect.php) function  <!-- .element: target="_blank" -->  will compute the intersection between two (or more) arrays

```php
<?php
  $a = array(1, 2, 3);
  $b = array(1, 3, 4);
  var_dump(array_intersect($a, $b)); // → array(2) { [0]=> int(1) [2]=> int(3) }
?>
```

---
## Project: simple blog
Using ALL the knowledge so far, implement a very simple blogging system

Some guidelines are given on the next slides.

--
## Templates
Allow users to create post based on templates