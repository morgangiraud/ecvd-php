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
    // Ok
    var_dump("ok");exit;
  }
} else {
  ecvdphp\addFlashMessage('error', 'The uploaded file couldn\'t be found');
}

ecvdphp\redirect("profile.php");