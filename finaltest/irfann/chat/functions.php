<?php

	namespace ECVChat{
		require 'pdo.php';

		use \PDO;

		require 'session.php';
		function redirect($route){
		  header('Location: /chat/' . $route, true, 301);
		  exit();  
		}

		function sanitizeString($string){
			$value = trim($string);
			$value = filter_var($value, FILTER_SANITIZE_STRING);

			return $value;
		}

		function checkUpload($fieldname){
			$extensions = array(IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png');
			$exifType = exif_imagetype($fieldname['tmp_name']);
			if(isset($extensions[$exifType]) && $fieldname['size'] != 0 && $fieldname['type'] == "image/jpeg" && $fieldname['error']==0){
        		return true;
        	}else{
        		return false;
        	}
		}

		function uploadFile($filename){
			global $conn;
			try {
				$uploaddir ='uploads/';
				$uploadfile = $uploaddir . basename($_FILES[$filename]['name']);
          
          		if (move_uploaded_file($_FILES[$filename]['tmp_name'], $uploadfile)) {
          			$path = $_FILES[$filename]['name'];
					$ext = pathinfo($path, PATHINFO_EXTENSION);
					$el = array();
					array_push($el, $_FILES[$filename]['name'], $ext);


					$conn->beginTransaction();
					$result = $conn->prepare('insert into files values (null, :filename, :path, :extension)');
			        $result->bindParam(":filename", basename($_FILES[$filename]['name']), PDO::PARAM_STR);
			        $result->bindParam(":path", $uploadfile, PDO::PARAM_STR);
			        $result->bindParam(":extension", $ext, PDO::PARAM_STR);
			        $result->execute();
			        $lastId=$conn->lastInsertId();
			        


			        $result = $conn->prepare('UPDATE users SET photo_id = :photo_id where id =:id_user');
		            $result->bindParam(":photo_id", $lastId, PDO::PARAM_INT);
		            $result->bindParam(":id_user", $_SESSION['user_id'], PDO::PARAM_INT);
		            $result->execute();

			        $conn->commit();

          			return $el;
          		}
            
			} catch (Exception $e) {
			    echo "Echec de d'upload de fichier";
			}
		}


		function addImage($filename, $uploadfile, $type)
		{
			global $conn;
			try{
				$conn->beginTransaction();
				$result = $conn->prepare('insert into file values (null, :filename, :path, :extension)');
		        $result->bindParam(":filename", $filename, PDO::PARAM_STR);
		        $result->bindParam(":path", $uploadfile, PDO::PARAM_STR);
		        $result->bindParam(":extension", $type, PDO::PARAM_STR);
		        $result->execute();
		        $lastId=$conn->lastInsertId();
		        $conn->commit();
		        
		        
				return $lastId;
			}catch (Exception $e){
				echo $e->getMessage();
			}
		}
	}

	namespace ECVChat\DB{
		require 'pdo.php';
		use \PDO;
		use \ECVChat as chat;

		function register($username, $password, $email){
			global $conn;
			try {
				$password = password_hash($password, PASSWORD_BCRYPT);

				$conn->beginTransaction();
				$result = $conn->prepare('insert into users values (null, :mail, :username, :pwd, null)');
	            $result->bindParam(":username", $username, PDO::PARAM_STR);
	            $result->bindParam(":mail", $email, PDO::PARAM_STR);
	            $result->bindParam(":pwd", $password, PDO::PARAM_STR);
	            $result->execute();
	            $conn->commit();

	            chat\redirect('login.php');
            
			} catch (Exception $e) {
			    return null;
			}
		}

		function login($username, $password){
			global $conn;

			try {

				$pass = $conn->prepare('select password from users');
				$pass->execute();
	            $allPass = $pass->fetchAll();
	            foreach ($allPass as $key => $value) {
	            	if(password_verify($password, $allPass[$key]["password"])){
	            		$password = $allPass[$key]["password"];
	            	}
	            }

				$result = $conn->prepare('select * from users where username = :username and password = :pwd');
	            $result->bindParam(":username", $username, PDO::PARAM_STR);
	            $result->bindParam(":pwd", $password, PDO::PARAM_STR);
	            $result->execute();

	            if($result->fetch()){
	            	$_SESSION['user_id'] = $result->fetch()["id"];
               		$_SESSION['username'] = $result->fetch()["username"];
               		$_SESSION['photo_id'] = $result->fetch()["photo_id"];
	            }

	            chat\redirect('chat.php');
            
			} catch (Exception $e) {
			    echo "Echec de l'identification";
			}
		}

		function updateUserImage($userId, $filename, $path, $extension){
			global $conn;
			try {
				$conn->beginTransaction();
				$result = $conn->prepare('UPDATE files SET filename=:filename, path=:path, extension=:extension where id = :userId');
	            $result->bindParam(":userId", $userId, PDO::PARAM_STR);
	            $result->bindParam(":filename", $filename, PDO::PARAM_STR);
	            $result->bindParam(":path", $path, PDO::PARAM_STR);
	            $result->bindParam(":extension", $extension, PDO::PARAM_STR);
	            $result->execute();
	            $lastId=$result->lastInsertId();
	            $conn->commit();

            	return $lastId;
			} catch (Exception $e) {
			    return null;
			}
		}

		function addMessage($message){
			global $conn;
			date_default_timezone_set('UTC');
			$date = date("Y-m-d h:i:s");
			try {
				$conn->beginTransaction();
				$result = $conn->prepare('insert into messages values (null, :message, :date, :user_id)');
		        $result->bindParam(":message", $message, PDO::PARAM_STR);
		        $result->bindParam(":date", $date, PDO::PARAM_STR);
		        $result->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
		        $result->execute();
		        $conn->commit();
			} catch (Exception $e) {
			  	return null;
			}
		}

		function getLastMessage(){
			global $conn;

			try {
				$result = $conn->prepare('select * from messages ORDER BY id DESC LIMIT 10');
		        $result->bindParam(":message", $message, PDO::PARAM_STR);
		        $result->bindParam(":date", $date, PDO::PARAM_STR);
		        $result->execute();

		        return $result->fetchAll();
			} catch (Exception $e) {
			    return null;
			}
		}

		function getUser($id){
			global $conn;

			try {
				$result = $conn->prepare('select * from users where id=:id');
		        $result->bindParam(":id", $id, PDO::PARAM_INT);
		        $result->execute();
		        return $result->fetch();
			} catch (Exception $e) {
			    return null;
			}
		}

	}
?>