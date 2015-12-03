<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

$uploadDir = __DIR__.'/uploads/';
$urlExploded = explode("/", $_SERVER["REQUEST_URI"]);
array_pop($urlExploded);
$path = implode("/", $urlExploded) . "/uploads";

if(isset($_FILES['filedata']) && is_uploaded_file($_FILES['filedata']['tmp_name']) && $_FILES['filedata']['size'] != 0){
  if($_FILES['filedata']['error'] !== UPLOAD_ERR_OK){
    ecvdphp\addFlashMessage('error', 'An error happened while uploading your file');
  } else if(!preg_match('/jpeg|jpg|png/', $_FILES['filedata']['type'])){
    ecvdphp\addFlashMessage('error', 'You can only upload jpeg or png files');
  } else {
    $fullname = basename($_FILES['filedata']['name']);
    list($filename, $extension) = explode(".", $fullname);
    $uploadfile = $uploadDir . $fullname;

    if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
      try {
        updateUserImage($_SESSION['id'], $filename, $path, $extension);
      } catch (Exception $e) {
        ecvdphp\addFlashMessage('error', $e->getMessage());
        header('Location:profile.php', true, 301);
        exit();
      }

      ecvdphp\addFlashMessage('success', 'Your profile has been updated');
      header('Location:profile.php', true, 301);
      exit();
    } else {
      ecvdphp\addFlashMessage('error', 'The uploaded file couldn\'t not be uploadeded');
    }
  }
} else if(isset($_POST['file-url']) && !empty($_POST['file-url']) && !!filter_var($_POST['file-url'], FILTER_VALIDATE_URL)){
  $url = $_POST['file-url'];
  $fullname = basename($url);
  list($filename, $extension) = explode(".", $fullname);
  $uploadfile = $uploadDir . $fullname;

  $f = fopen($url, 'rb');
  if($f){
    $content = "";
    while($data = fread($f, 1024)){
      $content .= $data;
    }
    fclose($f);
    file_put_contents($uploadfile, $content);

    try {
      updateUserImage($_SESSION['id'], $filename, $path, $extension);
    } catch (Exception $e) {
      ecvdphp\addFlashMessage('error', $e->getMessage());
      header('Location:profile.php', true, 301);
      exit();
    }

  } else {
    ecvdphp\addFlashMessage('error', 'The URL couldn\'t not be found');
  }
} else {
  ecvdphp\addFlashMessage('error', 'The uploaded file couldn\'t be found');
}

ecvdphp\redirect("profile.php");