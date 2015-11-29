<?php
$f = fopen('http://php.net', 'r');
$page = '';
if ($f) {
  while ($s = fread($f, 1000)) { // This is a way in PHP, to receive a stream of information
    $page .= $s; 
  }
}
echo $page;