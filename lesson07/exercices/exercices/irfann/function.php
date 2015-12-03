<?php
	
	function getUser($name, $pwd) {
		global $conn;
		try {
            $result = $conn->prepare('select * from users where username = :username and password = :password');
            $result->bindParam(":username", $name, PDO::PARAM_STR);
            $result->bindParam(":password", $pwd, PDO::PARAM_STR);
            $result->execute();

       		return $result;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
	}

	function fullUser($name, $pwd){
		global $conn;
		try {
            $result = $conn->prepare('select * from users inner join file on file.id = users.idAvatar where username = :username and password = :password');
            $result->bindParam(":username", $name, PDO::PARAM_STR);
            $result->bindParam(":password", $pwd, PDO::PARAM_STR);
            $result->execute();

       		return $result->fetch();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
	}

	function getAvatar($idAvatar){
		global $conn;

		try {
	        $avatar = $conn->prepare('select * from file where id = :idAvatar');
	        $avatar->bindParam(":idAvatar", $idAvatar, PDO::PARAM_INT);
	        $avatar->execute();

	        foreach ($avatar->fetchAll() as $row => $link) {
	          $av = $link['path'];
	        }
	    } catch (Exception $e) {
	        echo $e->getMessage();
	    }

	    return $av;
	}

	function innerJoin($idAvatar){
		global $conn;

		try {
	        $avatar = $conn->prepare('select * from users inner join file on file.id = :idAvatar');
	        $avatar->bindParam(":idAvatar", $idAvatar, PDO::PARAM_INT);
	        $avatar->execute();

	        foreach ($avatar->fetchAll() as $row => $link) {
	          $av = $link['path'];
	        }
	    } catch (Exception $e) {
	        echo $e->getMessage();
	    }

	    return $av;
	}

	function insert($filename, $uploadfile, $type, $user, $pwd){
		global $conn;
		try {
            $conn->beginTransaction();
            $result = $conn->prepare('insert into file values (null, :filename, :path, :extension)');
            $result->bindParam(":filename", $filename, PDO::PARAM_STR);
            $result->bindParam(":path", $uploadfile, PDO::PARAM_STR);
            $result->bindParam(":extension", $type, PDO::PARAM_STR);
            $result->execute();

            $avatar = $conn->prepare('select id from file where path = :path');
            $avatar->bindParam(":path", $uploadfile, PDO::PARAM_STR);
            $avatar->execute();

            foreach ($avatar->fetchAll() as $row => $link) {
              $av = $link['id'];
              }

          	$result = $conn->prepare('UPDATE users SET idAvatar = :avatar where username = :user and password = :pass');
            $result->bindParam(":avatar", $av, PDO::PARAM_INT);
            $result->bindParam(":user", $user, PDO::PARAM_STR);
            $result->bindParam(":pass", $pwd, PDO::PARAM_STR);
            $result->execute();

            $conn->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
	}

	function getAllPosts(){
		global $conn;

		try {
            $result = $conn->prepare('select * from posts');
            $result->execute();

            return $result->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
	}

	function addPosts($title, $body, $image_id, $user_id){
		global $conn;
		date_default_timezone_set('UTC');
		$date = date("Y-m-d h:i:s");
		try{
			$result = $conn->prepare('insert into posts values (null, :title, :body, :user_id, :image_id, :created_at)');
			$result->bindParam(":title", $title, PDO::PARAM_STR);
            $result->bindParam(":body", $body, PDO::PARAM_STR);
            $result->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $result->bindParam(":image_id", $image_id, PDO::PARAM_INT);
            $result->bindParam(":created_at", $date, PDO::PARAM_STR);
            $result->execute();
		}catch (Exception $e){
			echo $e->getMessage();
		}
	}

	function editPost($title, $body, $image_id, $idPost){
		global $conn;

		try{
          	$result = $conn->prepare('UPDATE posts SET title = :title, body = :body, image_id = :image_id where id = :idPost');
			$result->bindParam(":title", $title, PDO::PARAM_STR);
            $result->bindParam(":body", $body, PDO::PARAM_STR);
            $result->bindParam(":idPost", $idPost, PDO::PARAM_INT);
            $result->bindParam(":image_id", $image_id, PDO::PARAM_INT);
            $result->execute();

		}catch (Exception $e){
			echo $e->getMessage();
		}
	}

	function deletePost($postId){
		global $conn;

		try {
            $result = $conn->prepare('DELETE FROM posts where id = :postId');
			$result->bindParam(":postId", $postId, PDO::PARAM_INT);
            $result->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
	}

	function getImage($id){
		global $conn;

		try {
            $result = $conn->prepare('select path from file where id = :id');
            $result->bindParam(":id", $id, PDO::PARAM_INT);
            $result->execute();

            return $result->fetch();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
	}

?>