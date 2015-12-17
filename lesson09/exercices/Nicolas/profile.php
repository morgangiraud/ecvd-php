<?php
	require_once('bdd.php');
	require_once('session.php');

	if(isset($_FILES['img']) && $_FILES['img']['error'] == 0){
		if($_FILES['img']['size'] <= 7000000){
			$detailsFile = pathinfo($_FILES['img']['name']);

			$filename = $detailsFile['filename'];
			$path = 'uploads/';
			$extension = $detailsFile['extension'];
			$extensionArray = array('jpg', 'jpeg', 'png', 'gif');

			if(in_array($extension, $extensionArray)){
				// $req = $bdd->prepare('INSERT INTO files(filename,path,extension) VALUES(?,?,?)');
				// $req->execute([$filename,$path,$extension]);

				// move_uploaded_file($_FILES['img']['tmp_name'], $path . $_FILES['img']['name']);
				echo "OK";
			} else{
				header('location: profile.php');
				exit;
			}
		} else{
			header('location: profile.php');
			exit;
		}
	} else{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo 'Bonjour ' . $_SESSION['pseudo']; ?></title>
		<style>
			label{
				display: block;
				margin: 20px;
			}
		</style>
	</head>
	<body>
		<p>Ajoute une image à ton profil :</p>
		<form action="profile.php" method="post" enctype="multipart/form-data">
			<label>
		    	<input type="file" name="img">
			</label>
			<label>
		    	<input type="submit" value="Envoyer l'image">
			</label>
		</form>
	</body>
</html>
<?php
	}
?>