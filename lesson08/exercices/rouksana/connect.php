<?php

try{
  $conn = new PDO("mysql:host=127.0.0.1;dbname=ecvdphp", 'root', '');
} 
catch (\PDOException $e){
  die('Erreur : ' . $e->getMessage());
}
