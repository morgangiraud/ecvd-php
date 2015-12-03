<?php require_once('session.php');

if(isset($_SESSION['username'])) {
	require_once('return_home.php');
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
			require_once('functions.php');

			use Ecvdphp\User;

			if(isset($_POST['name'])) {

				if(ctype_alpha($_POST['name']) {
					User::insertUser($_POST['name'], $_POST['password']);
					$_SESSION['username'] = $_POST['name'];

					require_once('return_home.php');
				} else {
					echo 'Problem format username';
				}				

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
