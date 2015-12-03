<?php

namespace Php;

class Helper {

	public static function redirect($dest){
	  header('Location: '.$dest);
	  exit(); 
	}

	public static function insert($name, $password, $email) {
		require_once('connect.php');

		$name = filter_var($name, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
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

	public static function getUser($name) {
		require_once('connect.php');

		$stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
		$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch();

		return $user;
	}

	public static function getAllUsers($name, $password){
		require_once('connect.php');

		$stmt = $conn->prepare('SELECT username, password FROM users WHERE username = :username AND password = :password');
		$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
		$stmt->bindParam(':password', $password, \PDO::PARAM_STR);
		$stmt->execute();
		$users = $stmt->fetchAll();

		return $users;
	}

	public static function urlExists($url) {
	    $headers = get_headers($url);
		if(strpos($headers[0],'200')){
			return true;
		}else{
			return false;
		}
	}

}