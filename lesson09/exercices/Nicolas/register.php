<?php
require_once('bdd.php');

if(isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password'])){

	$pseudo = $_POST['pseudo'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$req = $bdd->prepare('INSERT INTO users(username,email,password) VALUES(?,?,?)');
	$req->execute(array($pseudo, $email, $password));

	header('location: http://localhost:8000/index.php');
} else{ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>Enregistrement</title>
		<style type="text/css">
			label{
				display: block;
				margin: 20px;
			}
		</style>
	</head>
	<body>
		<form action="register.php" method="post">
			<label>
				<input type="text" name="pseudo" placeholder="pseudo">
			</label>
			<label>
				<input type="email" name="email" placeholder="Email">
			</label>
			<label>
				<input type="password" name="password" placeholder="Mot de passe">
			</label>
			<label>
				<input type="submit" value="Envoyer">
			</label>
		</form>
	</body>
</html>
<?php 
	}
?>