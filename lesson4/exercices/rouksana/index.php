<!DOCTYPE html>
<html>
<head>
	<title>PHP</title>
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

<?php

	try{
	  $conn = new PDO("mysql:host=127.0.0.1;dbname=ecvdphp", 'rouksana', 'azerty');
	  $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Activate exception
	} catch (\PDOException $e){
	  echo $e->getMessage();
	}

	// $result = $conn->query('SELECT * FROM users');
	
	// foreach  ($result as $row) {
 //        echo($row['id']."\n");
 //        echo($row['username']."\n");
 //        echo($row['email']."\n");
 //        echo($row['password']."\n");
 //    }

	$file = 'users.txt';

	if($_SERVER['REQUEST_METHOD'] === "POST"){

		if(empty($_POST['name']) || empty($_POST['password']) ){

			echo('Champ non rempli');

		}else{
			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            $insert = $conn->query('INSERT INTO users (id, username, email, password) VALUES (null, "'.$_POST['name'].'", "'.$_POST['email'].'", "'.$_POST['password'].'")');
		
            if(!$insert){
            	echo('ERROR');
            } else{
            	echo('Incrit ! <br> <a href="login.php">Login</a>');
            }
		}	

	}
?>

</body>
</html>