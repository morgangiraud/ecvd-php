<?php
	session_start();
	session_regenerate_id();

	if(isset($_SESSION['name'])){
		echo ('Deja connecte <br> <a href="logout.php">Logout</a>');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP</title>
	<meta charset="utf-8" />
</head>
<body>
	<h1>Login</h1>

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
	echo('Nom : '.$_POST['name'].'<br>');
	echo('Mot de passe : '.$_POST['password'].'<br>');

	require_once('connect.php');
	$get = $conn->query('SELECT * FROM users');
	$users = $get->fetchAll();

	if($_SERVER['REQUEST_METHOD'] === "POST"){

		if(empty($_POST['name']) || empty($_POST['password']) ){

			echo('Champ non rempli');

		}else{

			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

			foreach ($users as $key => $user) {
				
				$getname = $user['username'];
				$getpwd = $user['password'];

				if($getname == $name && $getpwd == $password){
					$_SESSION['name'] = $_POST['name'];
                        
               		echo ('Connecte ! <br>');
					echo ('<a href="logout.php">Logout</a><br>');
					echo ('<a href="profile.php">Profile</a>');
				}
				else{
					echo ('Error');
				}

            }
		}

	}else{

		echo ('Non connecte.');

	}

?>

</body>
</html>