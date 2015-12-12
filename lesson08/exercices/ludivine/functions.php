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
?>