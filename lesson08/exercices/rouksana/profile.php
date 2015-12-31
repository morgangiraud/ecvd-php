<?php
	require_once ('session.php');
	require_once('function.php');

	if(!isset($_SESSION['name'])){
		User\redirect('index.php');
	}

	$user = User\getUser($_SESSION['name']);

	if(isset($_POST['delete'])) {
		User\delete($_SESSION['name']);
		session_destroy();
		User\redirect('index.php');
	}

	if(isset($_POST['edit'])) {
	    User\edit($_SESSION['name'], $_POST['email'], $_POST['password']);
		echo ('Profil modifié');
	}

	if(isset($_FILES['file']) || isset($_POST['url'])) {

		if($_POST['url'] && User\urlExists($_POST['url'])){
			list($name, $extension) = User\downloadFile($_POST['url']);
		}else{
			list($name, $extension) = User\uploadFile($_FILES['file']['name'], $_FILES['file']['tmp_name']);
		}

		$path = 'upload/';
		$imageId = User\updateUserImage($_SESSION['name'], $name, $path, $extension);
		$avatar = $path . $name . "." . $extension;

		if(isset($avatar)){ 
			echo ('File Upload');
		}else{
			echo ('No file uploaded');
		}
	}

	if($_SESSION['name']){
		$avatar = User\getAvatar($user['id']);
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
	<br>
	<a href="blog.php">BLOG</a>
	<br>
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
		<label>Url</label>
		<input type="text" name="url">
		<br>
    	<input type="submit" value="Add file">
	</form>
	
<?php include('footer.php');?>