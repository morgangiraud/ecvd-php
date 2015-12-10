<?php

namespace Ecvdphp;
require_once('connect.php');

class User {

	public static function insertUser($username = '', $password = '') {
		global $bdd;

		$password = password_hash($password, PASSWORD_BCRYPT);

		try {
			$insert = $bdd->prepare("INSERT INTO `users` (`username`, `password`, `email`, `description`) VALUES (:username, :password, '', 'Ceci est une description tirée de la BDD du user');");
			$insert
				->bindParam(':username', $username, \PDO::PARAM_STR);
				->bindParam(':password', $password, \PDO::PARAM_STR);
				->execute();
		} catch (Exception $e) {
			die("Some error occured while the register process : ".$e);
		}
	}

	public static function getUser($username = '') {
		global $bdd;

		$username = ($username === '') ? $_SESSION['username'] : $username;

		// On récupère les utilisateurs enregistrés dans la base de données
		$response = $bdd->prepare("SELECT * FROM `users` WHERE `username` = :username");
		$response
				->bindParam(':username', $username, \PDO::PARAM_STR);
				->execute();

		return $response->fetch();
	}

	public static function getFileById($file_id) {
		global $bdd;

		$response = $bdd->prepare("SELECT * FROM `files` WHERE `id` = :file_id");
		$response
			->bindParam(':file_id', $file_id, \PDO::PARAM_STR);
			->execute();

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

					} else { $result = "The file type doesn't correspond."; }
				} else { $result = 'Bug from filesize.'; }
			} else { $result = $file['error']; }

		} else {
			$result = "Bug from the file. Doesn't exist or has been bad uploaded.";
		}

		return $result;
	}

	public static function moveFile($file, $source) {

		global $bdd;

		$dir = '../upload/'.time().'_';
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
			$result = 'Error !';
		}

		return $result;
	}
}

class Post {

	public static function insertPost() {
		global $bdd;

		$title = $_POST['title'];
		$body = $_POST['body'];

		$getPicture = User::checkFile();

		$picture = (!is_array($getPicture)) ? null : User::moveFile($getPicture, 'post');
		$date = date_format(date_create(), 'Y-m-d H:i:s');
		$user = User::getUser();

		try {
			$insert = $bdd->prepare("
				INSERT INTO `posts` (`title`, `body`, `user_id`, `image_id`, `created_at`) 
				VALUES 				(:title, :body, :user_id, :image_id, :created_at)
			");

			$insert
				->bindParam(':title', $title, \PDO::PARAM_STR);
				->bindParam(':body', $body, \PDO::PARAM_STR);
				->bindParam(':user_id', $user['id'], \PDO::PARAM_INT);
				->bindParam(':image_id', $picture, \PDO::PARAM_INT);
				->bindParam(':created_at', $date, \PDO::PARAM_STR);
				->execute();

			echo '<a href="post.php?id='.$bdd->lastInsertId().'">Go see your post</a>';

		} catch (Exception $e) {
			die("Some error occured while the register process : ".$e);
		}
	}

	public static function editPost($id, $title, $body) {
		global $bdd;

		try {
			$update = $bdd->prepare("UPDATE `posts` SET `title` = :title, `body` = :body WHERE id = :id ");

			$update
				->bindParam(':id', $id, \PDO::PARAM_INT);
				->bindParam(':title', $title, \PDO::PARAM_STR);
				->bindParam(':body', $body, \PDO::PARAM_STR);

			if($update->execute()) {
				echo 'The modifications have been done !';
			}
			
		} catch (Exception $e) {
			die("Some error occured while the register process : ".$e);
		}
	}

	public static function deletePost($id) {
		global $bdd;

		try {
			$delete = $bdd->prepare("DELETE FROM `posts` WHERE id = :id ");
			$delete->bindParam(':id', $id, \PDO::PARAM_INT);

			if($delete->execute()) {
				echo 'Your post have been deleted ! <a href="index.php">Return to your posts list</a>';
			} else {
				echo 'error';
			}
			
		} catch (Exception $e) {
			die("Some error occured while the register process : ".$e);
		}
	}

	public static function getPostById($user_id = 1, $post_id = 1) {
		global $bdd;

		try {
			$response = $bdd->prepare("SELECT * FROM `posts` WHERE `user_id` = :user_id AND `id` = :id");
			$response
				->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
				->bindParam(':id', $post_id, \PDO::PARAM_STR);
				->execute();

			return $response->fetch();
		} catch(Exception $e) {
			die('error');
		}
	}

	public static function getAllPosts($user_id) {
		global $bdd;

		try {
			$response = $bdd->prepare("SELECT * FROM `posts` WHERE `user_id` = :user_id");
			$response
				->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
				->execute();

			return $response->fetchAll();

		} catch(Exception $e) {
			die('error ' . $e);
		}

		return $posts;
	}
}
