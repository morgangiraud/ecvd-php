<?php session_start(); 

if(!isset($_SESSION['username'])) {
	header("Location: first.php");
	exit();
}

?>

<!DOCTYPE HTML>

<html>

	<head>
		<title>Profile page</title>
		<meta charset="utf-8" />
	</head>

	<body>

		<?php

			// On récupère la connexion à la BDD
			require_once('connect.php');

			// Si l'utilisateur a demandé à supprimer son compte
			if(isset($_POST['delete'])) {
				$delete = $bdd->prepare("DELETE FROM `users` WHERE `username` = ?");
				$delete->execute(array($_SESSION['username']));
				header("Location: logout.php");
				
			} elseif(isset($_POST['update'])) {
				
			}

			$response = $bdd->prepare("SELECT * FROM `users` WHERE `username` = ?");
			$response->execute(array($_SESSION['username']));
			$datas = $response->fetch();

		?>

		<a href="first.php">Retour</a>

		<h2>Bienvenue sur votre page de profil <?= $_SESSION['username'] ?>!</h2>

		<?= $datas['description'] ?>

		<form action="profile.php" method="post">
			<input type="hidden" name="delete" />
			<button>Supprimer mon compte</button>
		</form>

		<form action="profile.php" method="post">
			<input type="hidden" name="update" />

			<div>
				<label for="password">Password</label>
				<input type="password">
			</div>

			<div>
				<label for="email">Email</label>
				<input type="email" />
			</div>

			<button>Modifier Profil</button>
		</form>
		
	</body>

</html>
