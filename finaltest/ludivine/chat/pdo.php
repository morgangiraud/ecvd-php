<?php 

	$host = "localhost";
	$dbname = "ecvchat";
	$username = "root";
	$password = "";

	global $conn;

	try{

		$conn = new PDO('mysql:host=localhost;dbname=ecvchat', $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	catch (PDOException $e) {

    echo 'Échec lors de la connexion : ' . $e->getMessage();

	}

?>