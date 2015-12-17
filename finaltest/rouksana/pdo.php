<?php
	try {
		$host = "127.0.0.1"; 
		$name = "ecvchat";
		$username = "root";
		$password = "";

		$conn = new PDO("mysql:host=$host;dbname=$name", $username, $password);
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	} 
	catch (\PDOException $e) {
	 	die('Erreur : ' . $e->getMessage());
	 	exit;
	}

