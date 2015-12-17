<?php
	require_once('session.php');
	//var_dump($_SESSION['pseudo']);
	//var_dump($_SESSION['email']);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile utilisateur</title>
		<style type="text/css">
			label{
				display: block;
				margin: 20px;
			}
		</style>
	</head>
	<body>
		<p>Ajouter une image :</p>
		<form action="profile.php" method="post" enctype="multipart/form-data">
			<label>
		    	<input type="file" name="fileToUpload" id="fileToUpload">
			</label>
			<label>
		    	<input type="submit" value="Upload Image" name="submit">
			</label>
		</form>
	</body>
</html>