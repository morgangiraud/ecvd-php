<?php
namespace ecvdphp;

function redirect($dest){
  header('Location: ' . $dest, true, 301);
  exit();  
}

function initFlashMessage(){
  if(!isset($_SESSION['flash-message'])){
    $_SESSION['flash-message'] = [];
    return true;
  }
  return false;
}

function hasFlashMessage(){
  return (isset($_SESSION['flash-message']) && count($_SESSION['flash-message']));
}

function addFlashMessage($type, $message){
  initFlashMessage();
  $_SESSION['flash-message'][] = [
    "type" => $type,
    "message" => $message,
  ];
}

function displayFlashMessage(){
  foreach ($_SESSION['flash-message'] as $key => $data) {    
    echo "<p class=\"{$data['type']}\">{$data['message']}</p>";
  }
  unset($_SESSION['flash-message']);
}