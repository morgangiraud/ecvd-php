<?php
	require_once ('session.php');
	require_once('function.php');
	
	if(isset($_SESSION['name'])){
		echo ('Deja connecte <br> <a href="logout.php">Logout</a>
			<br> <a href="profile.php">Profile</a>');
	}
	include('header.php');
?>
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

	$user = User\login($name, $password);
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(empty($_POST['name']) || empty($_POST['password']) ){
			echo('Champ non rempli');
		}else if(isset($user)){
			$_SESSION['name'] = $name;
       		echo ('Connecte ! <br>');
			echo ('<a href="logout.php">Logout</a><br>');
			echo ('<a href="profile.php">Profile</a>');
		}
		else{
			echo('Error');
		}
	}else{
		echo ('Non connecte.');
	}
?>
<?php include('footer.php');?>