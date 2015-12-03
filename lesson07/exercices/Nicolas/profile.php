<?php
	require_once('session.php');

	if(isset($_FILES['file-name']) && $_FILES['file-name']['error'] == 0){
		if($_FILES['file-name']['size'] <= 	7000000){
			var_dump($_FILES['file-name']['type']);
			echo "\n\n";

			var_dump($_FILES['file-name']['name']);
			$infosfichier = pathinfo($_FILES['file-name']['name']);
			var_dump($infosfichier['dirname']);
			//$extension_upload = $infosfichier['extension'];
			//var_dump($extension_upload);
			//if($_FILES['file-name']['type'] == '')
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