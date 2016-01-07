<?php

require_once('session.php');
require_once('pdo.php');
require_once('functions.php');

if($_FILES['userfile'] || $_POST['userfileurl']) {    
        
    
    // if($_POST['userfileurl'] && urlExists($_POST['userfileurl'])) {
    //     $fileName = end(explode('/', $_POST['userfileurl']));
    //     $source = $_POST['userfileurl'];
    //     file_put_contents($uploadsDir . $fileName, file_get_contents($source));
    //     setProfilePicture($fileName);
    // };
    
    $fileName = $_FILES['userfile']['name'];
    $fileTmpName = $_FILES['userfile']['tmp_name'];
    $uploadsDir = 'uploads/';

    if( checkUpload($fileName, $fileTmpName) ) {
    	$uplodaded = uploadFile($fileName, $fileTmpName);

    	if( $uplodaded != null ) {
    		updateUserImage($_SESSION["id"], $uplodaded['filename'], $uploadsDir, $uplodaded['extension']);
    	}
    }
}