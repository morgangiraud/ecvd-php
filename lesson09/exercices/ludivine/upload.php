<?php

$uploaddir = "img/";

if (isset($_FILES['filedata']) && $_FILES['filedata']['size'] > 0) {


	$nomTemp = $_FILES['filedata']['tmp_name'];
	$nomFichier = $_FILES['filedata']['name'];
	$tailleFichier = $_FILES['filedata']['size'];
	$typeFichier = getimagesize($nomTemp);
	$extensions = array (".gif", ".png", ".jpg");
	$extension = strrchr($_FILES['filedata']['name'], '.');
	$tailleMax = 100000;

	$nomFichier = explode(".", $nomFichier);


		if (in_array ($extension, $extensions)) {
			if ($tailleFichier <= $tailleMax) {
				if (move_uploaded_file($nomTemp, $uploaddir . $nomFichier[0])) {
					echo "Téléchargement réussi !";

				} else {
					echo " Le téléchargement a malheureusement échoué !";
					}
			} else {
				echo " Le fichier uploadé est trop gros !";
				}
		} else {
			echo " Il ne s'agit pas d'un fichier gif, png ou jpg !";
			}
}
$filehandle = opendir($uploaddir);
while ($file = readdir($filehandle)) {
	if ($file != "." && $file != "..") {
		$tailleFichier = getimagesize($uploaddir.$file);
		echo "<img src='$uploaddir$file'>";
	}
}

closedir($filehandle); 

require('connect_db.php');
?>