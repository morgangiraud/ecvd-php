<?php session_start(); ?>

<!DOCTYPE HTML>

<html>

	<head>
		<title>Test PHP</title>
		<meta charset="utf-8" />
	</head>

	<body>

		<?php

			// try {
			//     $bdd = new PDO('mysql:host=localhost;dbname=ecv', 'root', '');
			// }
			// catch (Exception $e) {
			//     die('Erreur : ' . $e->getMessage());
			// }

			// $reponse = $bdd->query('SELECT * FROM lesson2');
			// $donnees = $reponse->fetch();

			// $username = $donnees['username'];
			// $password = $donnees['password'];

			$file = 'data.txt';

			$username = '';
			$password = '';

			if(file_exists($file)) {
				$content = explode(";", file_get_contents($file));
				$username = $content[0];
				$password = $content[1];
			}





			if(isset($_SESSION['username'])) {
				echo 'Vous êtes bien connecté !';
			} else if(isset($_POST['name']) && !isset($_SESSION['username'])) {

				if(isset($_POST['name'])) {
				
					if($_POST['name'] === $username) {

						if($_POST['password'] === $password) {
							echo 'Vous êtes bien connecté !';
							$_SESSION['username'] = $_POST['name'];
						} else {
							echo 'Votre password n\'est pas correct ';
						}

					} else {
						echo 'Votre username n\'est pas correct';
					}
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

			<?php }

		?>

		<form action="logout.php" method="post" />
			<button>Disconnect</button>
		</form>
		
	</body>

</html>
