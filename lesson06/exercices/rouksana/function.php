<?php

namespace Php{
	include('connect.php');

	function redirect($dest){
	  header('Location: '.$dest);
	  exit(); 
	}

	function insert($name, $password, $email) {
		global $conn;

		$name = filter_var($name, FILTER_SANITIZE_STRING);
        $password = password_hash(filter_var($password, FILTER_SANITIZE_STRING),PASSWORD_BCRYPT);
        $email = filter_var($email, FILTER_SANITIZE_STRING);

		try {
			$stmt = $conn->prepare('INSERT INTO users (id, username, email, password) VALUES (null, :username, :email, :password)');
			$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, \PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, \PDO::PARAM_STR);
			$stmt->execute();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	
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

	function getUser($name) {
		global $conn;

		$stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
		$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch();

		return $user;
	}

	function delete($name) {
		global $conn;

		$name = filter_var($name, FILTER_SANITIZE_STRING);

		try {
			$stmt = $conn->prepare('DELETE FROM users WHERE username = :username');
			$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
			$stmt->execute();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	
	}
	
	function edit($name, $email, $password) {
		global $conn;

		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$email = filter_var($email, FILTER_SANITIZE_STRING);
        $password = password_hash(filter_var($password, FILTER_SANITIZE_STRING),PASSWORD_BCRYPT);

		try {
			$stmt = $conn->prepare('UPDATE users SET email = :email, password = :password WHERE username = :username');
			$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, \PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, \PDO::PARAM_STR);
			$stmt->execute();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	
	}

	function uploadFile($filename, $tmp){

		$upload = basename($filename);
		$folder = 'upload/' . $upload;

		list($name, $extension) = explode(".", $upload);

			if(move_uploaded_file($tmp, $folder)){
				return [$name, $extension];
			}
	
	}

	function updateUserImage($user, $filename, $path, $extension){
		global $conn;

		$conn->beginTransaction();

		$insert = $conn->prepare("INSERT INTO files (filename, path, extension) VALUES (:filename, :path, :extension)");
		$insert->bindParam(':filename', $filename, \PDO::PARAM_STR);
		$insert->bindParam(':path', $path, \PDO::PARAM_STR);
		$insert->bindParam(':extension', $extension, \PDO::PARAM_STR);
		$insert->execute();
		$imageId = $conn->lastInsertId();  

		$update = $conn->prepare("UPDATE users SET image_id = :id WHERE username = :username");
		$update->bindParam(':id', $imageId, \PDO::PARAM_STR);
		$update->bindParam(':username', $user, \PDO::PARAM_STR);
		$update->execute();

		$conn->commit();

		return $imageId;
	}

}