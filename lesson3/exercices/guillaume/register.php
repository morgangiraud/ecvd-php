<?php session_start();

if(isset($_SESSION['username'])) {
	header("Location: first.php");
	exit();
}
?>

<!DOCTYPE HTML>

<html>

	<head>
		<title>Test PHP</title>
		<meta charset="utf-8" />
	</head>

	<body>

		<?php

			function write_file($file, $username, $password) {

				$handle = fopen($file, 'a');

				$content = ','.$username.';'.$password;

				fwrite($handle, $content);
				fclose($handle);
			}

			if(isset($_POST['name'])) {

				write_file('data.txt', $_POST['name'], $_POST['password']);

				echo 'Vous êtes bien connecté !';
				$_SESSION['username'] = $_POST['name'];
				echo '<a href="logout.php">Disconnect</a>';

			} else { ?>

				<form action="register.php" method="post">

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

				<a href="first.php">Login</a>

			<?php }

		?>
		
	</body>

</html>
