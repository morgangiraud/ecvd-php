<?php
	require_once ('session.php');
	require_once('function.php');
	use Php\Helper;

	$name = $_SESSION['name'];

	if(!isset($name)){
		Helper::redirect('index.php');
	}

	$user = Helper::getUser($name);

    $password = filter_var($user['password'], FILTER_SANITIZE_STRING);
    $email = filter_var($user['email'], FILTER_SANITIZE_STRING);

	if(isset($_POST['delete'])) {
		include('connect.php');
		$stmt = $conn->prepare('DELETE FROM users WHERE username = :username');
		$stmt->bindParam(':username', $name, PDO::PARAM_STR);
		$stmt->execute();

		session_destroy();
		Helper::redirect('index.php');
	}

	if(isset($_POST['edit'])) {
		include('connect.php');
	    $newpassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	    $newemail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

		$stmt = $conn->prepare('UPDATE users SET email = :email, password = :password WHERE username = :username');
		$stmt->bindParam(':username', $name, PDO::PARAM_STR);
		$stmt->bindParam(':email', $newemail, PDO::PARAM_STR);
		$stmt->bindParam(':password', $newpassword, PDO::PARAM_STR);
		$stmt->execute();

		echo ('Profil modifié');
	}

	if(isset($_FILES['file'])) { 
		include('connect.php');
		$folder = 'upload/';
		$file = basename($_FILES['file']['name']);
		if(move_uploaded_file($_FILES['file']['tmp_name'], $folder . $file)) {
		  echo 'Upload';
		} else {
		  echo 'Echec';
		}
		
		$insert = $conn->prepare("INSERT INTO files (id, filename, path, extension) VALUES ('', :filename, :path, :extension)");
		$insert->bindParam(':filename', $_FILES['file']['name'], PDO::PARAM_STR);
		$insert->bindParam(':path', $folder, PDO::PARAM_STR);
		$insert->bindParam(':extension', $_FILES['file']['type'], PDO::PARAM_STR);
		$insert->execute(); 

		$update = $conn->prepare("UPDATE users SET image_id= :id WHERE username = :username");
		$update->bindParam(':id', $conn->lastInsertId(), PDO::PARAM_STR);
		$update->bindParam(':username', $name, PDO::PARAM_STR);
		$update->execute();
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

	<h3>Add file</h3>
	<form method="post" action="" enctype="multipart/form-data">
		<label>Fichier</label>
		<input type="file" name="file">
		<br>
    	<input type="submit" value="Add file">
	</form>
	
<?php include('footer.php');?>