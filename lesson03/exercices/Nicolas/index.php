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

			$fp = fopen('users.txt', 'r+');

			$loggedUser = false;

			while(($input = fgets($fp)) && !$loggedUser){
				$userData = explode('-', $input);
				$size = count($userData);

				for($i=0; $i<$size; $i++){
					$userData[$i] = trim($userData[$i]);
				}

				if($pseudo == $userData[0] && $password == $userData[2]){
					$loggedUser = true;
				}
			}

			if($loggedUser){
				echo "Vous êtes connecté !";
			} else{
				echo "Vous n'êtes pas connecté !";
			}

			fclose($fp);
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