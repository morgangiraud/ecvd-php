<?php
	require_once ('session.php');
	require_once('function.php');

	$name = $_SESSION['name'];
	$user = User\getUser($name);
	
	if(!isset($name)){
		User\redirect('index.php');
	}

	if(isset($_POST['delete'])) {
		User\delete($name);
		session_destroy();
		User\redirect('index.php');
	}

	if(isset($_POST['email']) && isset($_POST['password']) ){
		User\edit($name, $_POST['password'], $_POST['email']);
		echo ('Profil modifié');
	}else{
		echo('Champ non rempli');
	}

	$folder = 'upload/';
	function addFile($filename, $extension){
		include('connect.php');
		try{
	 		$conn->beginTransaction();

			$insert = $conn->prepare("INSERT INTO files VALUES ('', :filename, :path, :extension)");
			$insert->bindParam(':filename', $filename, PDO::PARAM_STR);
			$insert->bindParam(':path', $folder, PDO::PARAM_STR);
			$insert->bindParam(':extension', $extension, PDO::PARAM_STR);
			$insert->execute();

			$update = $conn->prepare("UPDATE users SET image_id = :id WHERE username = :username");
			$update->bindParam(':id', $conn->lastInsertId(), PDO::PARAM_STR);
			$update->bindParam(':username', $name, PDO::PARAM_STR);
			$update->execute();

			$conn->commit();
			echo 'Upload';
	 	} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	if(isset($_FILES['file']) || isset($_POST['url'])) { 

		if($_POST['url']){
			$filename = end(explode('/', $_POST['url']));
		}else{
			$filename = basename($_FILES['file']['name']);
		}

		if(move_uploaded_file($_FILES['file']['tmp_name'], $folder . $filename)) {
			addFile($_FILES['file']['name'], $_FILES['file']['type']);
		} 
		elseif(Blog\urlExists($_POST['url'])){
			$url = $_POST['url'];
			$type = 'image/jpeg';
			file_put_contents($folder.$filename, file_get_contents($url));
			addFile($filename, $type);
		}
		else {
			echo 'Echec';
		}
	}

	if($name){
		include('connect.php');
		$stmt = $conn->prepare('SELECT * FROM users LEFT JOIN files ON files.id = users.image_id WHERE users.id = :id');
		$stmt->bindParam(':id', $user['id'], PDO::PARAM_STR);
		$stmt->execute();
		$data = $stmt->fetch();

		$dir = $data['path'].$data['filename'];
		
	}else{
		User\redirect('index.php');
	}

	include('header.php');
?>
	<h1>Profile</h1>
	<h2>Hello <?php echo $name; ?> !</h2>

	<a href="post.php">BLOG</a>
	<br>
	<a href="logout.php">Logout</a>
	<br>
	<br>
	<?php if($dir):?>
		<img src="<?php echo $dir;?>" alt="image">
	<?php endif;?>
	<br>
	
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