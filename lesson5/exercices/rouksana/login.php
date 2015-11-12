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
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	echo('Nom : '.$name.'<br>');
	echo('Mot de passe : '.$password.'<br>');

	require_once('connect.php');

	$stmt = $conn->prepare('SELECT username, password FROM users WHERE username = :username AND password = :password');
	$stmt->bindParam(':username', $name, PDO::PARAM_STR);
	$stmt->bindParam(':password', $password, PDO::PARAM_STR);
	$stmt->execute();
	$users = $stmt->fetchAll();

	if($_SERVER['REQUEST_METHOD'] === "POST"){

		if(empty($_POST['name']) || empty($_POST['password']) ){

			echo('Champ non rempli');

		}else{

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