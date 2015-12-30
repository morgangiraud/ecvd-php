<?php
require('session.php');
require('functions.php');
require('header.php');

	$file = file ('users.txt');
		if(isset($_POST['nom']) && empty($_POST['pseudo']) == false && isset($_POST['password']) && empty($_POST['password']) == false && isset($_POST['email']) && empty($_POST['email']) == false) {
	try{

		 $result = $conn->prepare('SELECT username, password, email FROM users WHERE username = :username AND password = :password AND email = :email');
                $result->bindParam(':username', $_POST['pseudo'], PDO::PARAM_STR);
                $result->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
                $result->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                $result->execute();
                if($result->fetchAll()) {
                    $_SESSION['login']=$_POST['pseudo'];
                    $_SESSION['password']=$_POST['password'];

                    header('Location: connect.php');
                     exit;	
        }

}catch (\PDOException $e){
                echo $e->getMessage();
            }

    }
    else {
       die('no post data to process');
    }
        
?>

<?php

echo md5($_POST["password"]);


?>
