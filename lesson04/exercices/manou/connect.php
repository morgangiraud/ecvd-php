<?php
session_start();
session_regenerate_id();

try{
	$host ="127.0.0.1";

	$db_Username = "manou";
	$db_password ="root";
	$db_Name = "ecvdphp";
	

	$conn = new PDO("mysql:host =$host; db_name= $db_name", $db_username, $db_password);
	$conn->setAttribut(PDO::ATTR_MODE, PDO::ERRMODE_EXCEPTION);
}catch{
	echo $e->getMessage();
	exit;
}
?>