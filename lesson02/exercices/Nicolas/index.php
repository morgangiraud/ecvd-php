<?php session_start();
//var_dump($_COOKIE);

/*if (isset($_SESSION['idUser'])) {
	echo $_SESSION['idUser'];
} else {
	$_SESSION['idUser'] = 1;
}*/

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Test</title>
		<meta charset='utf-8'>
		<style type="text/css">
			label{
				display: block;
			}
		</style>
	</head>
	<body>
		<?php
		if (!isset($_POST['pseudo']) && !isset($_POST['password'])) { ?>
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
		<?php
		} else {
			$pseudo = 'nico';
			$mdp = 'test';

			if ($_POST['pseudo'] == $pseudo && $_POST['password'] == $mdp) {
				echo "Vous êtes connecté !";
			} else {
				echo "Pseudo & mot de passe faux !";
			}
		}
		?>
	</body>
</html>

<!--2137042418   pqjf2j466j2jhpdrf4isjv0i13	-->