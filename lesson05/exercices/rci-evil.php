<?php
$stmt = $conn->prepare("SELECT * FROM users");
if($stmt->execute()){
  $result = $stmt->fetchAll();
  var_dump($result);
}   
?>