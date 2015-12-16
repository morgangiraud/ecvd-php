<?php
	require_once('function.php');

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(empty($_POST['name']) || empty($_POST['password']) ){
			echo('Champ non rempli');
		}else{
			User\insert($_POST['name'], $_POST['password'], $_POST['email']);
		}	
	}
	include('header.php');
?>
	<h1>Register</h1>

	<form method="post" action="">
		<label>Nom</label>
		<input name='name' type='text' id='name'/>
		<br>
		<label>E-mail</label>
		<input type='email' name='email' id='email' />
		<br>
		<label>Mot de passe</label>
		<input type='password' name='password' id='password' />
		<br>
		<input type='submit' value='Register' />
	</form>
	<br>
	<a href="login.php">Login</a>
	<br>
<?php include('footer.php');?>