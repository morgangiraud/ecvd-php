<?php
	require_once('connect.php');
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(empty($_POST['name']) || empty($_POST['password']) ){
			echo('Champ non rempli');
		}else{
			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

			$stmt = $conn->prepare('INSERT INTO users (id, username, email, password) VALUES (null, :username, :email, :password)');
			$stmt->bindParam(':username', $name, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);
			$insert = $stmt->execute();
		
            if(!$insert){
            	echo('ERROR');
            } else{
            	header("Location: login.php");
            }
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
	<br><a href="login.php">Login</a><br>
<?php include('footer.php');?>