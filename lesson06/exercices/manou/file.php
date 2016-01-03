<?php

$uploaddir = "img/";

if (isset($_FILES['filedata']) && $_FILES['filedata']['size'] > 0) {


	$nomTemp = $_FILES['filedata']['tmp_name'];
	$nomFichier = $_FILES['filedata']['name'];
	$tailleFichier = $_FILES['filedata']['size'];
	$typeFichier = getimagesize($nomTemp);
	$extensions = array (".gif", ".png", "jpg");
	$extension = strrchr($_FILES['filedata']['name'], '.');
	$tailleMax = 100000;

		if (!in_array ($extension, $extensions)) {
			if ($tailleFichier >= $tailleMax ) {
				if (move_uploaded_file($nomTemp, $uploaddir . $nomFichier)) {
					echo "<p> Téléchargement réussi !<br/>";

				} else {
					echo " Le téléchargement a malheureusement échoué !";
					}
			} else {
				echo " Le ficheir uploadé est trop gros !";
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

    	$username = "manou";
    	$password = "root";
    	$host = "127.0.0.1";
    	$dbname = "ecvdphp";

	    try{
	    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
	    }   
	    catch (\PDOException $e){
	    echo $e->getMessage();
	    }


?>