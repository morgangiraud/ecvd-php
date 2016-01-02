<?php
    $host = "127.0.0.1";
    $dbname = "ecvchat";
    $user = "root";
    $pass = "";
    try{
      $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Activate exception
    } catch (\PDOException $e){
      echo $e->getMessage();
    }
?>