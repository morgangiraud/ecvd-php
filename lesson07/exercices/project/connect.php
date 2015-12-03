<?php
try{
  $host = "127.0.0.1"; // Use an IP Adresse
  $dbName = "ecvdphp";
  $dbUsername = "ecvduser";
  $dbPassword = "ecvd";

  $conn = new PDO("mysql:host=$host;dbname=$dbName", $dbUsername, $dbPassword);
  $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Activate exception
} catch (\PDOException $e){
  echo $e->getMessage();
  exit;
}

function updateUserImage($userId, $filename, $path, $extension){
  global $conn;

  $conn->beginTransaction();
  $stmt = $conn->prepare("INSERT INTO files (filename, path, extension) VALUES (?, ?, ?)");
  $stmt->bindParam(1, $filename);
  $stmt->bindParam(2, $path);
  $stmt->bindParam(3, $extension);
  $stmt->execute();
  $id = $conn->lastInsertId();
  $stmt = $conn->prepare("UPDATE users u SET image_id = ? where u.id=?");
  $stmt->bindParam(1, $id);
  $stmt->bindParam(2, $userId);
  $stmt->execute();
  $conn->commit();
}