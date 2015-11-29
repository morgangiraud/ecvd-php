<?php
	
	function getUser($name, $pwd){
    	require("init.php");

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

	function getAvatar($idAvatar){
    	require("init.php");

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

	function insert($filename, $uploadfile, $type){
    	require("init.php");

		try {
            $result = $conn->prepare('insert into file values (null, :filename, :path, :extension)');
            $result->bindParam(":filename", $filename, PDO::PARAM_STR);
            $result->bindParam(":path", $uploadfile, PDO::PARAM_STR);
            $result->bindParam(":extension", $type, PDO::PARAM_STR);
            $result->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
	}

?>