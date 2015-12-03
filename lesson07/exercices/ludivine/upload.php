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

/*$params = ['http' => [
  'method' => 'POST',
  'content' => 'var1=val1'
]];
$ctx = stream_context_create($params);
$fp = fopen('http://www.google.fr', 'rb', false, $ctx);

if (isset($_POST["txt"]) && (isset($_FILES["filedata"]))) {

	echo $fp;
}*/

    	$username = "root";
    	$password = "";
    	$host = "127.0.0.1";
    	$dbname = "ecvdphp";

	    try{
	    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
	    }   
	    catch (\PDOException $e){
	    echo $e->getMessage();
	    }


	    try {

	    	$result = $conn->prepare('insert into files values (null, :filename, :path, :extension)');
	    	$result->bindParam(':filename', $nomFichier[0], PDO::PARAM_STR);
            $result->bindParam(':path', $uploaddir, PDO::PARAM_STR);
            $result->bindParam(':extension', $extension, PDO::PARAM_STR);
			$result->execute();
            /*var_dump($result);*/

            $update = $result->lastInsertId();
            $update = $conn->prepare('select * from users left join files on image.id = users.image_id;');

	    }

	    catch (\PDOException $e) {
            echo $e->getMessage();
         }

?>