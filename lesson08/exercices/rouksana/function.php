<?php

namespace User{
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

	function downloadFile($url){
		$upload = basename($url);
		$folder = 'upload/' . $upload;

		list($name, $extension) = explode(".", $upload);

		$content = file_get_contents($url);

		if($content){
			file_put_contents($folder, $content);
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

	function urlExists($url) {
	    $headers = get_headers($url);
		if(strpos($headers[0],'200')){
			return true;
		}else{
			return false;
		}
	}

	function getAvatar($id) {
		global $conn;

		$stmt = $conn->prepare('SELECT * FROM users LEFT JOIN files ON files.id = users.image_id WHERE users.id = :id');
		$stmt->bindParam(':id', $id, \PDO::PARAM_STR);
		$stmt->execute();
		$data = $stmt->fetch();

		$avatar = $data['path'].$data['filename'].'.'.$data['extension'];

		return $avatar;   
	}
}

namespace Blog{
	include('connect.php');

	function getAllPosts() {
		global $conn;

		$stmt = $conn->prepare('SELECT posts.id as id, posts.title as title, posts.user_id as user_id, posts.created_at as date, users.username as name FROM posts LEFT JOIN files ON files.id = posts.image_id LEFT JOIN users ON users.id = posts.user_id ORDER BY created_at');
		$stmt->execute();
		$posts = $stmt->fetchAll();

		return $posts;
	}

	function getPost($id) {
		global $conn;

		$stmt = $conn->prepare('SELECT posts.id as id, posts.title as title, posts.body as body, posts.image_id as image_id, posts.created_at as date, posts.user_id as user_id,  users.username as name, files.filename as filename, files.path as path, files.extension as extension FROM posts LEFT JOIN files ON files.id = posts.image_id LEFT JOIN users ON users.id = posts.user_id WHERE posts.id = :id');
		$stmt->bindParam(':id', $id, \PDO::PARAM_STR);
		$stmt->execute();
		$post = $stmt->fetch();

		return $post;
	}

	function createPost($title, $body, $id) {
		global $conn;

        $body = filter_var($body, FILTER_SANITIZE_STRING);
	    $title = filter_var($title, FILTER_SANITIZE_STRING);

		try {
			$stmt = $conn->prepare('INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :id)');
			$stmt->bindParam(':title', $title, \PDO::PARAM_STR);
			$stmt->bindParam(':body', $body, \PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, \PDO::PARAM_STR);
			$stmt->execute();

			$id = $conn->lastInsertId();  
			return $id;
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	function updatePostImage($id, $filename, $path, $extension){
		global $conn;

		$conn->beginTransaction();

		$insert = $conn->prepare("INSERT INTO files (filename, path, extension) VALUES (:filename, :path, :extension)");
		$insert->bindParam(':filename', $filename, \PDO::PARAM_STR);
		$insert->bindParam(':path', $path, \PDO::PARAM_STR);
		$insert->bindParam(':extension', $extension, \PDO::PARAM_STR);
		$insert->execute();
		$imageId = $conn->lastInsertId();  

		$update = $conn->prepare("UPDATE posts SET image_id = :image_id WHERE id = :id");
		$update->bindParam(':image_id', $imageId, \PDO::PARAM_STR);
		$update->bindParam(':id', $id, \PDO::PARAM_STR);
		$update->execute();

		$conn->commit();

		return $imageId;
	}

	function deletePost($id) {
		global $conn;

		try {
			$stmt = $conn->prepare('DELETE FROM posts WHERE id = :id');
			$stmt->bindParam(':id', $id, \PDO::PARAM_STR);
			$stmt->execute();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	
	}

	function editPost($title, $body, $id, $user_id) {
		global $conn;

		$title = filter_var($title, FILTER_SANITIZE_STRING);
		$body = filter_var($body, FILTER_SANITIZE_STRING);

		try {
			$stmt = $conn->prepare('UPDATE posts SET title = :title, body = :body WHERE id = :id AND user_id = :user_id');
			$stmt->bindParam(':title', $title, \PDO::PARAM_STR);
			$stmt->bindParam(':body', $body, \PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, \PDO::PARAM_STR);
			$stmt->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
			$stmt->execute();

		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	
	}

}