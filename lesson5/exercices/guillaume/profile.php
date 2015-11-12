<?php require_once('session.php');

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
			require_once('header.php');

			// On récupère la connexion à la BDD
			require_once('connect.php');

			// Si l'utilisateur a demandé à supprimer son compte
			if(isset($_POST['delete'])) {
				
				try {
					$delete = $bdd->prepare("DELETE FROM `users` WHERE `username` = ?");
					$delete->execute(array($_SESSION['username']));
					header("Location: logout.php");
				} catch (Exception $e) {
					die("Couldn't delete your profile : ".$e)
				}
				
			} else if(isset($_POST['update'])) {

				if(!empty($_POST['email'])) {

					try {
						$update = $bdd->prepare("UPDATE `users` SET `email`= ? WHERE `username` = ?");
						$update->execute(array($_POST['email'], $_SESSION['username']));
						echo "Votre email a bien été modifié !";
					} catch (Exception $e) {
						die("Some error occured while the updating process : ".$e)
					}

				} else {
					echo 'Rentrez un email.';
				}
			}

			try {
				$response = $bdd->prepare("SELECT * FROM `users` WHERE `username` = ?");
				$response->execute(array($_SESSION['username']));
				$datas = $response->fetch();
			} catch (Exception $e) {
				die("Some error occured while looking for your profile : ".$e)
			}

		?>

		<a href="first.php">Retour</a>

		<h2>Bienvenue sur votre page de profil <?= $_SESSION['username'] ?>!</h2>

		<?= $datas['description'] ?>

		<form action="profile.php" method="post">
			<input type="hidden" name="delete" />
			<button>Supprimer mon compte</button>
		</form>

		<br><br>

		<form action="profile.php" method="post">
			<input type="hidden" name="update" />

			<div>
				<label for="email">E-mail</label>
				<input type="email" name="email" />
			</div>

			<button>Mettre à jour</button>
		</form>

		<?php require_once('footer.php'); ?>
		
	</body>

</html>
