<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>Formulaire</title>
		<style type="text/css">
			label{
				display: block;
				margin: 20px;
			}
		</style>
	</head>
	<body>
		<?php
		if(isset($_POST['pseudo']) && isset($_POST['password'])){
			$pseudo = $_POST['pseudo'];
			$password = $_POST['password'];

			if(empty($pseudo) && empty($password)){
				header('location: http://localhost:8000/index.php');
			}

			$host = '127.0.0.1';
			$dbname = 'ecvdphp';
			$user = 'nicolas';
			$pass = '';

			try{
			  $bdd = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
			  $bdd->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Activate exception
			} catch (\PDOException $e){
			  echo $e->getMessage();
			}

			//$bdd->exec('DELETE FROM users');

			$req = $bdd->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
			$req->execute(array($pseudo, $password));
			$data = $req->fetch();

			if($pseudo == $data['username'] && $password == $data['password']){
				$_SESSION['pseudo'] = $pseudo;
				$_SESSION['email'] = $data['email'];
				header('location: session.php');
			} else{
				header('location: index.php');
			}

		} else{ ?>
			<form action="index.php" method="post">
				<label>
					<input type="text" name="pseudo" placeholder="pseudo">
				</label>
				<label>
					<input type="password" name="password" placeholder="Mot de passe">
				</label>
				<label>
					<input type="submit" value="Envoyer">
				</label>
			</form>
			<a href="register.php">Enregistrez-vous</a>
			<?php
		}
		?>
	</body>
</html>