<?php
	require_once('bdd.php');
	require_once('session.php');

	if(isset($_FILES['file-name']) && $_FILES['file-name']['error'] == 0){
		if($_FILES['file-name']['size'] <= 	7000000){
			$extension = explode('/', $_FILES['file-name']['type']);
			$arrayExtensions = array('jpg', 'jpeg', 'png', 'gif');

			if(in_array($extension['1'], $arrayExtensions)){
				move_uploaded_file($_FILES['file-name']['tmp_name'], 'uploads/'.$_FILES['file-name']['name']);
				echo "Ok";
				// $bdd->prepare('INSERT INTO ')

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
		    	<input type="file" name="file-name">
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