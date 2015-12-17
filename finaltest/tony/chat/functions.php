<?php

function redirect ($route) {
	header('Location: ' . $route);
	exit;  
}

function sanitizeString ($string) {
	if(is_string($string)) {
		$string = stripslashes($string);
	    $string = htmlentities($string);
	    $string = strip_tags($string);
	    return $string;	
	}		
}

function checkUpload ($fileName, $fileTmpName) {

	$fileIsCorrect = false;


	if (is_uploaded_file($fileTmpName)) {    
	    
		if( filesize($fileTmpName) > 0 ) {
			$fileIsCorrect = true;	
		}

		$info = new SplFileInfo($fileName);
		$extension = $info->getExtension();

		if( $extension != 'jpg' && $extension != 'png' ) {
			$fileIsCorrect = false;
		}	    
	    
	}

	return $fileIsCorrect;

}

function uploadFile ($fileName, $fileTmpName) {
	global $conn;
	$uploadsDir = 'uploads/';

    $info = new SplFileInfo($fileName);
	$extension = $info->getExtension();

	if (move_uploaded_file($fileTmpName, $uploadsDir . $fileName)) {

		return array(
			"filename"	=> $fileName,
			"extension" => $extension
		);

	}
}


function updateUserImage ($userId, $filename, $path, $extension) {
	global $conn;
	$conn->beginTransaction();

	$query = $conn->prepare("INSERT INTO files VALUES (null, :filename, :path, :extension)");
    $query->bindParam(':filename', $filename, PDO::PARAM_STR);
    $query->bindParam(':path', $path, PDO::PARAM_STR);
    $query->bindParam(':extension', $extension, PDO::PARAM_STR);
    
    $query->execute();
    $query = $conn->prepare("UPDATE users SET photo_id= :id WHERE users.id = :userId");
    $query->bindParam(':id', $conn->lastInsertId(), PDO::PARAM_STR);
    $query->bindParam(':userId', $userId, PDO::PARAM_STR);
    $query->execute();

    $conn->commit();

    redirect('profile.php');
}








function register ($username, $password, $email) {
	global $conn;
	
	$stmt = $conn->prepare('INSERT INTO users VALUES (null, :email, :username, :password, null)');
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);
	$stmt->execute();

	redirect('login.php');
}


function getUserPhotoUrl ($userid) {
	global $conn;

    $query = $conn->prepare("SELECT path, filename FROM files, users WHERE users.id = :userid AND users.photo_id = files.id");
    $query->bindParam(':userid', $userid, PDO::PARAM_STR);
    $result = $query->execute();
    $result = $query->fetchAll();
    return $result[0]['path'] . $result[0]['filename'];
}