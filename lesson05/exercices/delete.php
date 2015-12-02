<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

session_destroy();
$stmt = $conn->prepare("DELETE FROM users WHERE id=:id");
$stmt->bindParam(':id', $_SESSION['id']);

if(!$stmt->execute()){
  addFlashMessage('error', 'Could not delete the user');
} else {
  addFlashMessage('success', 'Your account has been deleted');
}

redirect('login.php');