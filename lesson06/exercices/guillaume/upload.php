<?php require_once('session.php'); ?>

<!DOCTYPE HTML>

<html>

	<head>
		<title>Upload</title>
		<meta charset="utf-8" />

		<style>
			div {margin-top: 20px;}
		</style>

	</head>

	<body>

		<?php

			// $file = array();

			// $koko = checkFile();

			// if(!is_array($koko)) {
			// 	echo $koko;
			// } else {
			// 	moveFile($koko);
			// }


		?>

		<form action="upload.php" method="post" enctype="multipart/form-data">

			<input type="hidden" name="upload" value="true" />

			<div>
				<label for="filedata"></label>
				<input type="file" name="filedata" />
			</div>

			<div>
				<button>Uploader</button>
			</div>
		</form>
		
	</body>
</html>
