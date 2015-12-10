<?php

function userPosts() {
	global $conn;

        try {
        	$result = $conn->prepare('select * from posts');
        	$result->execute();
    	} catch (Exception $e) {
        	echo $e->getMessage();
    	}
	}
	return $result->fetchAll();
}

function updatedb() {
	global $conn;

	$update = $result->lastInsertId();
    $update = $conn->prepare('select * from posts left join files on image.id = posts.image_id;');
}

function addPosts() {
	global $conn;

        try {
        	$result = $conn->prepare('insert into posts values (null, :title, :body, :image_id)');
        	$result->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
        	$result->bindParam(":body", $_POST['body'], PDO::PARAM_STR);
        	$result->bindParam(":image_id", $_POST['filedata'], PDO::PARAM_STR);
        	$result->execute();
    	} catch (Exception $e) {
        	echo $e->getMessage();
    	}
}
?>