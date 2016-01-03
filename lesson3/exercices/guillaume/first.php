<?php session_start(); ?>

<!DOCTYPE HTML>

<html>

	<head>
		<title>Test PHP</title>
		<meta charset="utf-8" />
	</head>

	<body>

		<?php

			function read_file($file) {

				$username = '';
				$password = '';
				$content = '';

				if(file_exists($file)) {

					// On récupère la taille du fichier et la taille maximum de la mémoire
					$filesize = filesize($file);
					$memory = intval(substr(ini_get("memory_limit"), 0, -1));

					// On converti la mémoire en Octets en fonction de sa puissance (Kilo, Mega...)
					$last = strtolower(substr(ini_get("memory_limit"),-1));
					switch($last) {
				        case 'g':
				            $memory *= 1024 * 1024 * 1024;
				        case 'm':
				            $memory *= 1024* 1024;
				        case 'k':
				            $memory *= 1024;
				    }

				    /* Test pour passer dans le fread
				    	$filesize = $memory;
				    //*/

				    // Si le fichier est inférieur à la moitié de la mémoire
					if($filesize < $memory/2) {
						// On récupère le contenu par file get contents
						$content = explode(",", file_get_contents($file));
					} else {
						// Sinon on va lire le fichier par petits bouts
						$handle = fopen($file, "r");
						$result = '';

						while(!feof($handle)) {
							$result .= fread($handle, 1024);
						}

						$content = explode(",", $result);
						fclose($handle);
					}
				}
				return $content;
			}

			$content = read_file('data.txt');

			
			$username = $content[0];
			$password = $content[1];

			if(isset($_SESSION['username'])) {
				echo 'Vous êtes bien connecté !';
				echo '<a href="logout.php">Disconnect</a>';

			} else if(isset($_POST['name']) && !isset($_SESSION['username'])) {

				$result = '';

				for ($i=0; $i < count($content); $i++) {

					$data = explode(';', $content[$i]);

					$username = $data[0];
					$password = $data[1];

					if($_POST['name'] === $username) {

						if($_POST['password'] === $password) {
							echo 'Vous êtes bien connecté !';
							$_SESSION['username'] = $_POST['name'];
							echo '<a href="logout.php">Disconnect</a>';
							break;

						} else {
							$result = 'Votre password n\'est pas correct ';
						}

					} else {
						$result = 'Votre username n\'est pas correct';
					}
				}

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
