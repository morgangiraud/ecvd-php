<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

if(isset($_FILES['filedata']) && is_uploaded_file($_FILES['filedata']['tmp_name']) && $_FILES['filedata']['size'] != 0){
  if($_FILES['filedata']['error'] !== UPLOAD_ERR_OK){
    ecvdphp\addFlashMessage('error', 'An error happened while uploading your file');
  } else if(!preg_match('/jpeg|jpg|png/', $_FILES['filedata']['type'])){
    ecvdphp\addFlashMessage('error', 'You can only upload jpeg or png files');
  } else {
    $uploadDir = __DIR__.'/uploads/';
    $fullname = basename($_FILES['filedata']['name']);
    list($filename, $extension) = explode(".", $fullname);
    $uploadfile = $uploadDir . basename($_FILES['filedata']['name']);

    if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
      $urlExploded = explode("/", $_SERVER["REQUEST_URI"]);
      array_pop($urlExploded);
      $path = implode("/", $urlExploded) . "/uploads";

      $stmt = $conn->prepare("INSERT INTO files (filename, path, extension) VALUES (?, ?, ?)");
      $stmt->bindParam(1, $filename);
      $stmt->bindParam(2, $path);
      $stmt->bindParam(3, $extension);
      if($stmt->execute()){
        $id = $conn->lastInsertId();
        $stmt = $conn->prepare("UPDATE users u SET image_id = ? where u.id=?");
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $_SESSION['id']);
        if($stmt->execute()){
          ecvdphp\addFlashMessage('success', 'Your profile has been updated');
          header('Location:login.php', true, 301);
          exit();
        } else {
          $message = '<p>Something went wrong.</p>';
        }          
        header('Location:login.php', true, 301);
        exit();
      } else {
        $message = '<p>Something went wrong.</p>';
      }          
    } else {
      ecvdphp\addFlashMessage('error', 'The uploaded file couldn\'t not be uploadeded');
    }
  }
} else {
  ecvdphp\addFlashMessage('error', 'The uploaded file couldn\'t be found');
}

ecvdphp\redirect("profile.php");