<?php
namespace ECVChat;

function redirect($route)
{
	if($route){
		header('HTTP/1.0 404 Not Found');
	}
	header('Location :/index.php');
	exit();
}

namespace ECVChat\DB;

$severname ="localhost";
$username="root";
$password="";
$dbname="ecvchat";


function register($username, $password, $email)
{	
	if (!$username && !$password  && !$email){

		throw new Exception("It will be OK");
	}

	return (null);
}

try {
	$conn = new PDO("mysql:host=$servername;dbname=ecvchat", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $conn -> prepare("INSERT INTO users (username,password, email)
	VALUES (:username, :password, :email)");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $password);
	$stmt->bindParam(':email', $email);

	$username = " John Doe";
	$email = "john@example.com";
	$password="";
	$stmt->execute();

	}catch (PDOException $e){
	echo 'Error : '  .$e->getMesage();
}
$conn = null;

?>