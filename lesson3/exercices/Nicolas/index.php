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

			$fp = fopen('users.txt', 'r+');

			while ($ligne = fgets($fp)) {
				echo $ligne;
			}

			fclose($fp);


			//$pseudo = 'test';
			//$mdp = 'test';

			//if ($_POST['pseudo'] == $pseudo && $_POST['password'] == $mdp) {
				//echo "Vous êtes connecté !";

			//} else {
				//echo "Ton pseudo et ton mot de passe faux !";
			//}
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