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

?>