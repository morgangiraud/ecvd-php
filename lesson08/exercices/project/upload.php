<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

$urlExploded = explode("/", $_SERVER["REQUEST_URI"]);
array_pop($urlExploded);
$path = implode("/", $urlExploded) . "/uploads";

if(ecvdphp\checkUploadedFile('filedata')){
  if(!preg_match('/jpeg|jpg|png/', $_FILES['filedata']['type'])){
    ecvdphp\addFlashMessage('error', 'You can only upload jpeg or png files');
  } else {
    list($filename, $extension) = ecvdphp\saveUploadedImage($_FILES['filedata']['name']);

    try {
      ecvdphp\DB\updateUserImage($_SESSION['id'], $filename, $path, $extension);
    } catch (Exception $e) {
      ecvdphp\addFlashMessage('error', $e->getMessage());
      ecvdphp\redirect('profile.php');
    }

    ecvdphp\addFlashMessage('success', 'Your profile has been updated');
    ecvdphp\redirect('profile.php');
  }
} else if(isset($_POST['file-url']) && !empty($_POST['file-url']) && !!filter_var($_POST['file-url'], FILTER_VALIDATE_URL)){
  $fileUrl = $_POST['file-url'];
  
  list($filename, $extension) = ecvdphp\downloadImageFromUrl($fileUrl);

  try {
    ecvdphp\DB\updateUserImage($_SESSION['id'], $filename, $path, $extension);
  } catch (Exception $e) {
    ecvdphp\addFlashMessage('error', $e->getMessage());
    ecvdphp\redirect('profile.php');
  }

} else {
  ecvdphp\addFlashMessage('error', 'The uploaded file couldn\'t be found');
  ecvdphp\redirect('profile.php');
}

ecvdphp\redirect("profile.php");