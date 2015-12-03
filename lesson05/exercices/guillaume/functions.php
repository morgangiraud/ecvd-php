<?php

namespace Ecvdphp;

class User {

	// Fonction d'insertion d'un user en BDD
	function insert_user($username = '', $password = '') {
		require_once('connect.php');

		$password = password_hash($password, PASSWORD_BCRYPT);

		try {
			$insert = $bdd->prepare("INSERT INTO `users` (`username`, `password`, `email`, `description`) VALUES (:username, :password, '', 'Ceci est une description tirée de la BDD du user');");
			$insert->bindParam(':username', $username, PDO::PARAM_STR);
			$insert->bindParam(':password', $password, PDO::PARAM_STR);
			$insert->execute();
		} catch (Exception $e) {
			die("Some error occured while the register process : ".$e);
		}
	}

	// On récupère la connexion à la BDD
	function getUser($username = '') {
		require_once('connect.php');
		// On récupère les utilisateurs enregistrés dans la base de données
		$response = $bdd->prepare("SELECT * FROM `users` WHERE `username` = :username");
		$response->bindParam(':username', $username, PDO::PARAM_STR);
		$response->execute();
		return $response->fetchAll();
	}
}

