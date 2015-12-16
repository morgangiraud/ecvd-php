<?php

namespace User {
	include('connect.php');

	function redirect($dest){
	  header('Location: '.$dest);
	  exit(); 
	}

	function insert($name, $password, $email) {
		global $conn;
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

	function edit($name, $password, $email) {
		
		$newpassword = filter_var($password, FILTER_SANITIZE_STRING);
	    $newemail = filter_var($email, FILTER_SANITIZE_STRING);
	    
	    try {
			$stmt = $conn->prepare('UPDATE users SET email = :email, password = :password WHERE username = :username');
			$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
			$stmt->bindParam(':email', $newemail, \PDO::PARAM_STR);
			$stmt->bindParam(':password', $newpassword, \PDO::PARAM_STR);
			$stmt->execute();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	function delete($name){
		global $conn;

		try {
			$stmt = $conn->prepare('DELETE FROM users WHERE username = :username');
			$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
			$stmt->execute();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	function getUser($name) {
		global $conn;

		$stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
		$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch();

		return $user;
	}

	function getAllUsers($name, $password){
		global $conn;

		try {
			$stmt = $conn->prepare('SELECT username, password FROM users');
			$stmt->bindParam(':username', $name, \PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, \PDO::PARAM_STR);
			$stmt->execute();
			$users = $stmt->fetchAll();
			return $users;
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
		
	}
}

namespace Blog {

	function urlExists($url) {
	    $headers = get_headers($url);
		if(strpos($headers[0],'200')){
			return true;
		}else{
			return false;
		}
	}

}