<?php require_once('session.php');

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
		
			require_once('header.php');

			function insert_user($username, $password) {
				require_once('connect.php');

				$password = password_hash($password, PASSWORD_BCRYPT);

				try {
					$insert = $bdd->prepare("INSERT INTO `users` (`username`, `password`, `email`, `description`) VALUES (?, ?, '', 'Ceci est une description tirée de la BDD du user');");
					$insert->execute(array($username, $password));
				} catch (Exception $e) {
					die("Some error occured while the register process : ".$e);
				}
			}

			if(isset($_POST['name'])) {

				insert_user($_POST['name'], $_POST['password']);

				$_SESSION['username'] = $_POST['name'];

				header("Location: first.php");
				exit();

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

			<?php } require_once('footer.php');
		?>
		
	</body>

</html>
