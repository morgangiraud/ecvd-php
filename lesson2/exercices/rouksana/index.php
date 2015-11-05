<?php
	session_start();
	session_regenerate_id();
	//session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP</title>
</head>
<body>
	<h1>Hello World</h1>

	<form method="post" action="">
		<label>Nom</label>
		<input name='name' type='text' id='name'/>
		<br>
		<label>Mot de passe</label>
		<input type='password' name='password' id='password' />
		<br>
		<input type='submit' value='Connexion' />
	</form>

<br><br>
<?php
	echo('Nom : '.$_POST['name']);
	echo('<br>');
	echo('Mot de passe : '.$_POST['password']);
	echo('<br>');

	// $user = ['name' => 'rouksana', 'password' => 'azerty'];
	$users= file ('users.txt');

	if(isset($_SESSION['name'])){
		echo ('Deja connecte');
		echo('<br>');
		echo ('<a href="logout.php">Logout</a>');
	}else if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(empty($_POST['name']) || empty($_POST['password']) ){
			echo('Champ non rempli');
		}else{
			foreach ($users as $key => $user){
			$list = explode(';', $user);
				
			$user = str_replace(';', '', $user);
			$data = explode( ',', $user);

				if($_POST['name'] === $data[0] && $_POST['password'] === $data[1]){
					$_SESSION['name'] = $data[0];
					echo ('Connecte ! ');
					echo('<br>');
					echo ('<a href="logout.php">Logout</a>');
				}
				else{
					echo('Erreur');
					echo('<br>');
				}
			}
		}
	}else{
		echo ('Non connecte.');
	}

?>

</body>
</html>