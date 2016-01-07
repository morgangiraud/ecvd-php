<?php
	require_once('bdd.php');
	require_once('session.php');
	//$bdd->exec('DELETE FROM users');

	if(isset($_POST['pseudo']) && !empty($_POST['pseudo']) && isset($_POST['password']) && !empty($_POST['password'])){
		$pseudo = $_POST['pseudo'];
		$password = $_POST['password'];

		$req = $bdd->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
		$req->execute(array($pseudo, $password));
		$data = $req->fetch();

		if($pseudo == $data['username'] && $password == $data['password']){
			$_SESSION['pseudo'] = $pseudo;
			$_SESSION['email'] = $data['email'];
			header('location: profile.php');
		} else{
			header('location: index.php');
		}
	} else{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Connexion</title>
		<style>
			label{
				display: block;
				margin: 20px;
			}
		</style>
	</head>
	<body>
		<form action="index.php" method="post">
			<label>
				<input type="text" name="pseudo" placeholder="pseudo">
			</label>
			<label>
				<input type="password" name="password" placeholder="Mot de passe">
			</label>
			<label>
				<input type="submit" value="Connexion">
			</label>
		</form>
		<p>
			<a href="register.php">Enregistrez-vous</a>
		</p>
	</body>
</html>
<?php 
	}
?>