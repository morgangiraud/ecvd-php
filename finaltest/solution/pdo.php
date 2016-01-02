<?php
try{
  $host = "127.0.0.1"; // Use an IP Adresse
  $dbName = "ecvchat";
  $dbUsername = "root";
  $dbPassword = "r00t";

  $conn = new PDO("mysql:host=$host;dbname=$dbName", $dbUsername, $dbPassword);
  $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Activate exception
} catch (\PDOException $e){
  echo $e->getMessage();
  exit;
}