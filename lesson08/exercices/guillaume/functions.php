<?php

namespace Ecvdphp;

class User {

	// Fonction d'insertion d'un user en BDD
	public static function insertUser($username = '', $password = '') {
		require_once('connect.php');

		$password = password_hash($password, PASSWORD_BCRYPT);

		try {
			$insert = $bdd->prepare("INSERT INTO `users` (`username`, `password`, `email`, `description`) VALUES (:username, :password, '', 'Ceci est une description tirée de la BDD du user');");
			$insert->bindParam(':username', $username, \PDO::PARAM_STR);
			$insert->bindParam(':password', $password, \PDO::PARAM_STR);
			$insert->execute();
		} catch (Exception $e) {
			die("Some error occured while the register process : ".$e);
		}
	}

	// On récupère la connexion à la BDD
	public static function getUser($username = '') {
		if($username === '') $username = $_SESSION['username'];
		$bdd = new \PDO('mysql:host=localhost;dbname=ecvd_php', 'root', '');
		// On récupère les utilisateurs enregistrés dans la base de données
		$response = $bdd->prepare("SELECT * FROM `users` WHERE `username` = :username");
		$response->bindParam(':username', $username, \PDO::PARAM_STR);
		$response->execute();
		return $response->fetchAll();
	}

	public static function checkFile() {

		$result = '';

		if(isset($_FILES['filedata'])) {

			$file = $_FILES['filedata'];

			if($file['error'] === 0) {

				if($file['size'] !== 0) {

					if($file['type']) {

						return $file;

					} else {
						$result = "Le type de fichier ne correspond pas";
					}

				} else {
					$result = 'Bug de taille de fichier';
				}

			} else {
				$result = $file['error'];
			}

		} else {
			$result = "Bug de fichier";
		}

		return $result;
	}

	public static function moveFile($file, $source) {

		$dir = 'upload/'.time().'_';
		$filename = $dir.$file['name'];
		$result = '';

		if(move_uploaded_file($file['tmp_name'], $filename)) {

			try {
			    $bdd = new \PDO('mysql:host=localhost;dbname=ecvd_php', 'root', '');
			}
			catch (Exception $e) {
			    die('Erreur : ' . $e->getMessage());
			}

			try {
				
				$insert_file = $bdd->prepare("INSERT INTO `ecvd_php`.`files` (`id`, `filename`, `path`, `extension`) VALUES ('', ?, ?, ?)");

				$insert_file->execute(array($file['name'], $dir, $file['type'])); 
				$result = 'Good !';

			} catch (Exception $e) {
				$result = 'Erreur !';
			}

			if($source === 'profile') {
				User::updateUserPicture($bdd->lastInsertId());
			} else if($source === 'post') {
				return $bdd->lastInsertId();
			}

		} else {
			$result = 'Erreur !';
		}

		return $result;
	}

	public static function updateUserPicture($the_id) {

		try {
		    $bdd = new \PDO('mysql:host=localhost;dbname=ecvd_php', 'root', '');
		}
		catch (Exception $e) {
		    die('Erreur : ' . $e->getMessage());
		}

		try {
			$update = $bdd->prepare("UPDATE `users` SET `image_id`= ? WHERE `username` = ?");
			$update->execute(array($the_id, $_SESSION['username']));

			$result = 'Good !';
		} catch (Exception $e) {
			$result = 'Erreur !';
			// die("Some error occured while the updating process : ".$e);
		}
	}
}

