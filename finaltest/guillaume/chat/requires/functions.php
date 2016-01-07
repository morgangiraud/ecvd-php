<?php

namespace ECVChat;

require_once('pdo.php');

function redirect($redirection) {
	header('Location: '.$redirection);
}

function sanitizeString($string) {

	$string = trim($string);

	if(is_numeric($string)) {
		$string = filter_var($string, FILTER_SANITIZE_NUMBER_INT);

	} else if(is_string($string)) {

		if(filter_var($string, FILTER_VALIDATE_EMAIL)) {
			$string = filter_var($string, FILTER_SANITIZE_EMAIL);
		} else {
			$string = filter_var($string, FILTER_SANITIZE_STRING);
		}

	} else {
		return 'An Error Occured, your entry is not weel formated';
	}

	return $string;
}

function postExist($array) {

	foreach ($array as $value) {
		if(!isset($_POST[$value])) {
			return false;
		} else {
			if($_POST[$value] === '') return false;
		}
	}
	return true;
};

function initSession($id, $username, $photo_id) {
	global $conn;

	$_SESSION['id'] = intval($id);
	$_SESSION['username'] = $username;
	$_SESSION['photo_id'] = intval($photo_id);

	if($photo_id !== null && intval($photo_id) !== 0) {
		$response = $conn->prepare("SELECT * FROM files WHERE id = :id");
		$response->bindParam(':id', $photo_id, \PDO::PARAM_INT);
		$response->execute();

		$response = $response->fetchAll()[0];

		$_SESSION['photo_url'] = $response['path'].$response['filename'];
	}
}

function insertUser() {

	global $conn;

	if(postExist(array('username', 'email', 'password'))) {

		$username = sanitizeString($_POST['username']);
		$email = sanitizeString($_POST['email']);
		$password = sanitizeString($_POST['password']);

		$password = password_hash($password, PASSWORD_BCRYPT);

		try {
			$insert = $conn->prepare(
				"
				INSERT INTO users (username, password, email, photo_id) 
				VALUES (:username, :password, :email, 0)
				"
			);
			$insert->bindParam(':username', $username, \PDO::PARAM_STR);
			$insert->bindParam(':password', $password, \PDO::PARAM_STR);
			$insert->bindParam(':email', $email, \PDO::PARAM_STR);
			$insert->execute();

			redirect('login.php');

		} catch (Exception $e) {
			die("An error occured : ".$e);
		}

	} else {
		echo 'You did not filled all the fields';
	}
};

function login() {

	global $conn;

	if(postExist(array('username', 'password'))) {

		$username = sanitizeString($_POST['username']);
		$password = sanitizeString($_POST['password']);

		try {
			$response = $conn->prepare("SELECT * FROM users WHERE username = :username");
			$response->bindParam(':username', $username, \PDO::PARAM_STR);
			$response->execute();

			$datas = $response->fetchAll();

			if(isset($datas[0])) {

				if(password_verify($password, $datas[0]['password'])) {
					initSession($datas[0]['id'], $username, 0);
					redirect('chat.php');
				} else {
					echo 'Your password does not match your username';
				}

			} else {
				echo 'Your username has not been found';
			}

		} catch (Exception $e) {
			die("An error occured : ".$e);
		}

	} else {
		var_dump($_POST);
		die;
	}
}

function checkUpload($fieldname) {

		if(isset($_FILES[$fieldname])) {
			$file = $_FILES[$fieldname];

			if($file['error'] === 0) {
				if($file['size'] !== 0) {
					if($file['type'] === 'image/png' || $file['type'] === 'image/jpg' || $file['type'] === 'image/jpeg') {
						return true;
					}
				}
			}
		}
		return false;
}

function updatePhotoId($id) {
	global $conn;

	$update_user = $conn->prepare("UPDATE users SET photo_id = :photo_id WHERE username = :username");
	$update_user->bindParam(':photo_id', $id, \PDO::PARAM_INT);
	$update_user->bindParam(':username', $_SESSION['username'], \PDO::PARAM_STR);
	$update_user->execute();

	initSession($_SESSION['id'], $_SESSION['username'], $id);
}

 function uploadFile($filename) {

		global $conn;

		$dir = getcwd().DIRECTORY_SEPARATOR.'uploads/'.time().'_';
		$true_dir = 'uploads/'.time().'_';
		$the_filename = $dir.$filename['name'];
		$result = '';

		if(move_uploaded_file($filename['tmp_name'], $the_filename)) {

			try {
				$insert_file = $conn->prepare("
					INSERT INTO files (filename, path, extension) 
					VALUES (?, ?, ?)
				");
				$insert_file->execute(array($filename['name'], $true_dir, $filename['type']));

				updatePhotoId($conn->lastInsertId());
				return array($true_dir, $filename['name']);

			} catch (Exception $e) {
				die("An error occured : ".$e);
			}

		} else {
			echo 'Your file could not be uploaded';
		}
}

namespace ECVChat\DB;

function addMessage($message) {
	global $conn;

	$created_at = date_format(date_create(), 'Y-m-d H:i:s');

	try {
		$insert = $conn->prepare(
			"
			INSERT INTO messages (message, created_at, user_id) 
			VALUES (:message, :created_at, :user_id)
			"
		);
		$insert->bindParam(':message', $message, \PDO::PARAM_STR);
		$insert->bindParam(':created_at', $created_at, \PDO::PARAM_STR);
		$insert->bindParam(':user_id', $_SESSION['id'], \PDO::PARAM_INT);
		$insert->execute();

		return null;

	} catch (Exception $e) {
		die("Your message could not be sent because : ".$e);
	}
}

function getLastMessage() {

	global $conn;

	try {
		$messages = $conn->prepare("
			SELECT * FROM messages 
			LEFT JOIN users ON messages.user_id = users.id
			LEFT JOIN files ON users.photo_id = files.id
			ORDER BY messages.id DESC LIMIT 10
		");
		$messages->execute();

		return $messages->fetchAll();

	} catch (Exception $e) {
		die("Your message could not be sent because : ".$e);
	}
}
