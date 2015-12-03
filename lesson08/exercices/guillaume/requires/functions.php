<?php

namespace Ecvdphp;
require_once('connect.php');

class User {

	// Fonction d'insertion d'un user en BDD
	public static function insertUser($username = '', $password = '') {
		global $bdd;

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
		global $bdd;

		if($username === '') $username = $_SESSION['username'];

		// On récupère les utilisateurs enregistrés dans la base de données
		$response = $bdd->prepare("SELECT * FROM `users` WHERE `username` = :username");
		$response->bindParam(':username', $username, \PDO::PARAM_STR);
		$response->execute();
		return $response->fetch();
	}

	public static function getPostById($user_id = 1, $post_id = 1) {
		global $bdd;

		try {
			$response = $bdd->prepare("SELECT * FROM `posts` WHERE `user_id` = :user_id AND `id` = :id");
			$response->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
			$response->bindParam(':id', $post_id, \PDO::PARAM_STR);
			$response->execute();

			return $response->fetch();
		} catch(Exception $e) {
			die('error');
		}
	}

	public static function getFileById($file_id) {
		global $bdd;

		$response = $bdd->prepare("SELECT * FROM `files` WHERE `id` = :file_id");
		$response->bindParam(':file_id', $file_id, \PDO::PARAM_STR);
		$response->execute();

		return $response->fetch();
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

		global $bdd;

		$dir = 'upload/'.time().'_';
		$filename = $dir.$file['name'];
		$result = '';

		if(move_uploaded_file($file['tmp_name'], $filename)) {

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

		global $bdd;

		try {
			$update = $bdd->prepare("UPDATE `users` SET `image_id`= ? WHERE `username` = ?");
			$update->execute(array($the_id, $_SESSION['username']));

			$result = 'Good !';
		} catch (Exception $e) {
			$result = 'Erreur !';
		}

		return $result;
	}


	public static function insertPost() {
		global $bdd;

		$title = $_POST['title'];
		$body = $_POST['body'];

		$getPicture = User::checkFile();

		$picture = (!is_array($getPicture)) ? null : User::moveFile($picture, 'post');
		$date = date_format(date_create(), 'Y-m-d H:i:s');
		$user = User::getUser();

		try {

			$insert = $bdd->prepare("
				INSERT INTO `posts` (`title`, `body`, `user_id`, `image_id`, `created_at`) 
				VALUES 				(:title, :body, :user_id, :image_id, :created_at)
			");

			$insert->bindParam(':title', $title, \PDO::PARAM_STR);
			$insert->bindParam(':body', $body, \PDO::PARAM_STR);
			$insert->bindParam(':user_id', $user['id'], \PDO::PARAM_INT);
			$insert->bindParam(':image_id', $picture, \PDO::PARAM_INT);
			$insert->bindParam(':created_at', $date, \PDO::PARAM_STR);
			$insert->execute();

			echo '<a href="blog.php?id='.$bdd->lastInsertId().'">Go see your post</a>';

		} catch (Exception $e) {
			die("Some error occured while the register process : ".$e);
		}
	}
}
