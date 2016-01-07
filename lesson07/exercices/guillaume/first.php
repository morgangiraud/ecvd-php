<?php 

require_once('session.php'); ?>

<!DOCTYPE HTML>

<html>

	<head>
		<title>Test PHP</title>
		<meta charset="utf-8" />
	</head>

	<body>

		<?php

			require_once('header.php');
			require_once('functions.php');
			use Ecvdphp\User;

			// Si l'utilisateur est déjà enregistré en session, on lui propose de se déconnecter
			if(isset($_SESSION['username'])) {
				require_once('connected.php');

			// Sinon, on vérifie que les username et password entrés correspondent à un utilisateur
			} else if(isset($_POST['name']) && !isset($_SESSION['username'])) {

				$result = '';

				if(!empty($_POST['name']) && !empty($_POST['password'])) {

					$data = User::getUser($_POST['name']);

					// Pour chaque utilisateur, on check
					if(isset($data[0])) {

						if(password_verify($_POST['password'], $data[0]['password'])) {
							$_SESSION['username'] = $_POST['name'];
							require_once('connected.php');
						} else {
							$result = 'Votre mot de passe ne correspond pas';
						}

					} else {
						$result = 'Votre username ne correspond pas.';
					}

				} else {
					$result = 'Remplissez tous les champs.';
				}

				// Sinon, on lui affiche l'erreur
				if($result !== '') echo $result;

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

			require_once('footer.php');
		?>
		
	</body>

</html>
