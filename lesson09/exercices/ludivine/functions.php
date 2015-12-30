<?php

function userPosts() {
	global $conn;

	try {

		$result = $conn->prepare('select * from posts');
	}

	catch (\PDOException $e) {
        echo $e->getMessage();		
	}
	return $result;
}

function updatedb() {
	global $conn;

	$update = $result->lastInsertId();
    $update = $conn->prepare('select * from posts left join files on image.id = posts.image_id;');
}

	function addPosts(){
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

	function removePost($post){
		global $conn;
		try {
            $result = $conn->prepare('DELETE FROM posts where id = :post');
			$result->bindParam(":post", $post, PDO::PARAM_INT);
            $result->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
	}


	function getImage(){
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