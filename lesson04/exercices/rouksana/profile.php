<?php
	session_start();

	if(!isset($_SESSION['name'])){
		header("Location: index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP</title>
	<meta charset="utf-8" />
</head>
<body>
	<h1>Profile</h1>

<?php
	require_once('connect.php');

	$name = filter_var($_SESSION['name'], FILTER_SANITIZE_STRING);

	$getuser = $conn->query('SELECT * FROM users WHERE username = "'.$name.'"');
	$user = $getuser->fetch();

    $password = filter_var($user['password'], FILTER_SANITIZE_STRING);
    $email = filter_var($user['email'], FILTER_SANITIZE_STRING);

	if(isset($_POST['delete'])) {
		$delete = $conn->query('DELETE FROM users WHERE username = "'.$name.'"');
		session_destroy();	
	}

	if(isset($_POST['edit'])) {
	    $newpassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	    $newemail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
		$edit = $conn->query('UPDATE users SET email = "'.$newemail.'", password = "'.$newpassword.'" WHERE username = "'.$name.'" ');
		echo ('Profil modifié');
	}

?>
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
	
	</body>
</html>