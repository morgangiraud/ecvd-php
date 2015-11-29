<?php
	require_once ('session.php');
	require_once('connect.php');

	if(!isset($_SESSION['name'])){
		header("Location: index.php");
		exit();
	}

	$name = filter_var($_SESSION['name'], FILTER_SANITIZE_STRING);

	$stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
	$stmt->bindParam(':username', $name, PDO::PARAM_STR);
	$stmt->execute();
	$user = $stmt->fetch();

    $password = filter_var($user['password'], FILTER_SANITIZE_STRING);
    $email = filter_var($user['email'], FILTER_SANITIZE_STRING);

	if(isset($_POST['delete'])) {
		$stmt = $conn->prepare('DELETE FROM users WHERE username = :username');
		$stmt->bindParam(':username', $name, PDO::PARAM_STR);
		$stmt->execute();
		session_destroy();
		header("Location: index.php");	
	}

	if(isset($_POST['edit'])) {
	    $newpassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	    $newemail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

		$stmt = $conn->prepare('UPDATE users SET email = :email, password = :password WHERE username = :username');
		$stmt->bindParam(':username', $name, PDO::PARAM_STR);
		$stmt->bindParam(':email', $newemail, PDO::PARAM_STR);
		$stmt->bindParam(':password', $newpassword, PDO::PARAM_STR);
		$stmt->execute();

		echo ('Profil modifié');
	}
	include('header.php');
?>
	<h1>Profile</h1>
	<h2>Hello <?php echo $name; ?> !</h2>
	<a href="logout.php">Logout</a>

	<h3>Delete</h3>
	<form method="post" action="">
		<input type="hidden" name="delete" />
		<input type='submit' value='Delete' />
	</form>

	<h3>Edit</h3>
	<form method="post" action="">
		<label>E-mail</label>
		<input type='email' name='email' id='email'/>
		<br>
		<label>Mot de passe</label>
		<input type='password' name='password' id='password' />
		<br>
		<input type="hidden" name="edit" />
		<input type='submit' value='Edit' />
	</form>
	
<?php include('footer.php');?>