<!DOCTYPE html>
<html>
<head>
	<title>PHP</title>
	<meta charset="utf-8" />
</head>
<body>
	<h1>Register</h1>

	<form method="post" action="">
		<label>Nom</label>
		<input name='name' type='text' id='name'/>
		<br>
		<label>E-mail</label>
		<input type='email' name='email' id='email' />
		<br>
		<label>Mot de passe</label>
		<input type='password' name='password' id='password' />
		<br>
		<input type='submit' value='Connexion' />
	</form>

	<br>
	
	<a href="login.php">Login</a>

	<br>

<?php

	require_once('connect.php');

	if($_SERVER['REQUEST_METHOD'] === "POST"){

		if(empty($_POST['name']) || empty($_POST['password']) ){

			echo('Champ non rempli');

		}else{
			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

            $_SESSION['username'] = $_POST['name'];

            $insert = $conn->query('INSERT INTO users (id, username, email, password) VALUES (null, "'.$name.'", "'.$email.'", "'.$password.'")');
		
            if(!$insert){
            	echo('ERROR');
            } else{
            	echo('Incrit !');
            }
		}	

	}
?>

</body>
</html>