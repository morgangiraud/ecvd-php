<?php session_start(); ?>

<!DOCTYPE HTML>

<html>

	<head>
		<title>Test PHP</title>
		<meta charset="utf-8" />
	</head>

	<body>

		<?php

			// On récupère la connexion à la BDD

			function get_users() {
				require_once('connect.php');
				// On récupère les utilisateurs enregistrés dans la base de données
				$response = $bdd->query('SELECT * FROM users');
				return $response->fetchAll();
			}

			$datas = get_users();

			// Si l'utilisateur est déjà enregistré en session, on lui propose de se déconnecter
			if(isset($_SESSION['username'])) {
				echo 'Vous êtes bien connecté !';
				echo '<a href="logout.php">Disconnect</a><br />';
				echo '<a href="profile.php">Voir mon profil</a>';

			// Sinon, on vérifie que les username et password entrés correspondent à un utilisateur
			} else if(isset($_POST['name']) && !isset($_SESSION['username'])) {

				$result = '';

				// Pour chaque utilisateur, on check
				foreach ($datas as $key => $data) {

					$username = $data['username'];
					$password = $data['password'];

					if($_POST['name'] === $username) {

						// Si on le trouve, on le met en session
						if($_POST['password'] === $password) {
							echo 'Vous êtes bien connecté !';
							$_SESSION['username'] = $_POST['name'];
							echo '<a href="logout.php">Disconnect</a><br />';
							echo '<a href="profile.php">Voir mon profil</a>';
							$result = '';
							break;

						} else {
							$result = 'Votre password n\'est pas correct ';
						}

					} else {
						$result = 'Votre username n\'est pas correct';
					}
				}

				// Sinon, on lui affiche l'erreur
				if($result !== '') {
					echo $result;
				}

			} else { ?>

				<form action="first.php" method="post">

					<div class="style_input">
						<label for="name"></label>
						<input type="text" id="name" name="name" />
					</div>

					<div class="style_input">
						<label for="password"></label>
						<input type="password" id="password" name="password" />
					</div>
					
					<button>Envoyer</button>
				</form>

				<a href="register.php">Register</a>

			<?php }

		?>
		
	</body>

</html>
