<?php
	require_once ('session.php');
	require_once('function.php');

	if(!isset($_SESSION['name'])){
		Php\redirect('index.php');
	}

	$user = Php\getUser($_SESSION['name']);

	if(isset($_POST['delete'])) {
		Php\delete($_SESSION['name']);
		session_destroy();
		Php\redirect('index.php');
	}

	if(isset($_POST['edit'])) {
	    Php\edit($_SESSION['name'], $_POST['email'], $_POST['password']);
		echo ('Profil modifié');
	}

	if(isset($_FILES['file'])) { 

		list($name, $extension) = Php\uploadFile($_FILES['file']['name'], $_FILES['file']['tmp_name']);

		$path = 'upload/';
		$imageId = Php\updateUserImage($_SESSION['name'], $name, $path, $extension);
		$avatar = $path . $name . "." . $extension;

		if(isset($avatar)){ 
			echo ('File Upload');
		}else{
			echo ('No file uploaded');
		}
	}	

	include('header.php');
?>
	<h1>Profile</h1>
	<h2>Hello <?php echo $_SESSION['name']; ?> !</h2>
<?php 
        if($avatar != null){
          echo '<img src="' . $avatar . '"><br>';
        }
?>
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