<?php

try {
	$conn = new PDO('mysql:host=localhost;dbname=ecvchat', 'root', '');
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	print "Error : " . $e->getMessage() . "<br/>";
    die();
}