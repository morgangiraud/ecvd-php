<?php

namespace ECVChat {

	define('ECVChat\UPLOAD_DIR', __DIR__.'/uploads/');

	function redirect($route){
		header('Location: ' . $route);
		exit();
	}

	function sanitizeString($string){
		$string = filter_var($string, FILTER_SANITIZE_STRING);
		$string = trim($string);
		return $string;
	}

	function checkUpload($fieldname){
		if($_FILES[$fieldname]['error'] === UPLOAD_ERR_OK && $_FILES[$fieldname]['size'] != 0 && $_FILES[$fieldname]['type'] == 'image/jpeg' || $_FILES[$fieldname]['type'] == 'image/png' && is_uploaded_file($_FILES[$fieldname]['tmp_name'])){
			return true;
		}else{
			return false;
		}
	}

	function uploadFile($filename){
		$file = basename($filename);
		$folder = UPLOAD_DIR . $file;
		$tmp = $_FILES['filedata']['tmp_name'];
		list($name, $extension) = explode(".", $file);

		try {
			if(move_uploaded_file($tmp, $folder)){
				return [$name, $extension];
			}
		}
		catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}		
	}
}

namespace ECVChat\DB {
	include('pdo.php');

	function register($username, $password, $email){
		global $conn;

		$password = password_hash($password, PASSWORD_BCRYPT);

		$stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
		$stmt->bindParam(1, $username, \PDO::PARAM_STR);
		$stmt->bindParam(2, $email, \PDO::PARAM_STR);
		$stmt->bindParam(3, $password, \PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->execute()){
			$id = $conn->lastInsertId();
		}

		return $id;
	}

	function login($username, $password){
		global $conn;

		$stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
		$stmt->bindParam(1, $username, \PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->execute()){
			$user = $stmt->fetchAll();
			if(count($user) === 1 && password_verify($password, $user[0]['password'])) {
				$user = $user[0];
			}
		}

		return $user;
	}

	function updateUserImage($userId, $filename, $path, $extension){
		global $conn;

		$conn->beginTransaction();

		$insert = $conn->prepare("INSERT INTO files (filename, path, extension) VALUES (?, ?, ?)");
		$insert->bindParam(1, $filename, \PDO::PARAM_STR);
		$insert->bindParam(2, $path, \PDO::PARAM_STR);
		$insert->bindParam(3, $extension, \PDO::PARAM_STR);
		$insert->execute();
		$imageId = $conn->lastInsertId();  

		$update = $conn->prepare("UPDATE users SET photo_id = ? WHERE id = ?");
		$update->bindParam(1, $imageId, \PDO::PARAM_STR);
		$update->bindParam(2, $userId, \PDO::PARAM_STR);
		$update->execute();

		$conn->commit();

		return $imageId;
	}

	function addMessage($userId, $message){
		global $conn;

		try {
			$stmt = $conn->prepare('INSERT INTO messages (message, user_id) VALUES (?, ?)');
			$stmt->bindParam(1, $message, \PDO::PARAM_STR);
			$stmt->bindParam(2, $userId, \PDO::PARAM_STR);
			$stmt->execute();
			$id = $conn->lastInsertId();

			return $id;
		}
		catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	function getLastMessage(){
		global $conn;

		$sql = 
		"SELECT messages.id, messages.message, messages.created_at, users.username, files.path, files.filename, files.extension
		FROM messages 
		LEFT JOIN users ON messages.user_id = users.id
		LEFT JOIN files ON users.photo_id = files.id

		ORDER BY id DESC LIMIT 10";

		$result = $conn->query($sql)->fetchAll();
		return $result;
	}
}
