<?php
require_once 'session.php';
require_once 'pdo.php';
require_once 'functions.php';

require_once 'header.php';

if(isset($_SESSION['id'])){
  if($_SERVER['REQUEST_METHOD'] === "POST"){
    if (empty($_POST['message'])) {
      $message = '<p>Something went wrong. You must fill all the fields</p>';
    } else {
      $message = ECVChat\sanitizeString($_POST['message']);

      try {
        $user = ECVChat\DB\addMessage($message);
      } catch (Exception $e) {
        $message = '<p>' . $e->getMessage() . '</p>';
      }
    }
  }

  $messages = ECVChat\DB\getLastMessages();

  ECVChat\render('chat.php', array(
    "messages" => $messages
  ));
} else {
  ECVChat\render('login.php');
}

require_once 'footer.php';