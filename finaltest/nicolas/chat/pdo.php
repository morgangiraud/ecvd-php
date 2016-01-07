<?php
	$dsn = 'mysql:ecvchat=testdb;host=127.0.0.1';
	$user = 'root';
	$password = '';

	try{
	    $conn = new PDO($dsn, $user, $password);
	} catch(PDOException $e){
	    echo 'Connexion échouée : ' . $e->getMessage();
	}
?>