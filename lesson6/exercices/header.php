<!DOCTYPE html>
<html>
<head>
  <title><?php echo isset($title) ? $title : "Ecvd PHP";?></title>
</head>
<body>
<?php
require_once 'functions.php';

use function ecvdphp\hasFlashMessage;

if(hasFlashMessage()){
  ecvdphp\displayFlashMessage();
}