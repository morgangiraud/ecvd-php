<?php

// Fonction d'insertion d'un user en BDD
function insert_user($username, $password) {
	require_once('connect.php');

	$password = password_hash($password, PASSWORD_BCRYPT);

	try {
		$insert = $bdd->prepare("INSERT INTO `users` (`username`, `password`, `email`, `description`) VALUES (?, ?, '', 'Ceci est une description tirée de la BDD du user');");
		$insert->execute(array($username, $password));
	} catch (Exception $e) {
		die("Some error occured while the register process : ".$e);
	}
}

// On récupère la connexion à la BDD
function get_user($username) {
	require_once('connect.php');
	// On récupère les utilisateurs enregistrés dans la base de données
	$response = $bdd->prepare("SELECT * FROM `users` WHERE `username` = :koko");
	$response->bindParam(':koko', $username, PDO::PARAM_STR);
	$response->execute();
	return $response->fetchAll();
}

?>