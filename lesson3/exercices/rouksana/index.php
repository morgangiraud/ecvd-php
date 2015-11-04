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
		<label>Mot de passe</label>
		<input type='password' name='password' id='password' />
		<br>
		<input type='submit' value='Connexion' />
	</form>

<?php
	$file = 'users.txt';

	if($_SERVER['REQUEST_METHOD'] === "POST"){

		if(empty($_POST['name']) || empty($_POST['password']) ){

			echo('Champ non rempli');

		}else{
			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            $user = trim($name) . ',' . hash('haval256,5', trim($password)) . "\n";

            $add = file_put_contents($file, $user, FILE_APPEND);

            if(!$add){
            	echo('ERROR');
            } else{
            	echo('Incrit !');
            }
		}	

	}
?>

</body>
</html>