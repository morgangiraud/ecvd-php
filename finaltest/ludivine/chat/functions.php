<?php 

	namespace ECVChat;

	function redirect(route) {

		header('Location:');
		exit;
	}

	function login() {

		$login = $_POST["name"];
		$password = md5($_POST["pwd"]);
		$email = $_POST["email"];

		if (isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["pwd"]) && !empty($_POST["pwd"]) && isset($_POST["email"]) && !empty($_POST["email"])) {

  			$login = $_SESSION["name"];
  			$password = $_SESSION["password"];
  			$email = $_SESSION["email"];

			}
		else {

			return NULL;
		}
}

	function checkUpload(fieldname) {


	$uploaddir = '/img';
	$uploadfile = $uploaddir . basename ($_FILES['filedata']['name']);
	$extensions = array('.png', '.jpeg', '.jpg');
	$extension = strrchr($_FILES['filedata']['name'], '.');
	$fichier = $_FILES['filedata']['tmp_name'];
	$tailleMax = 100000;
	$tailleFichier = $_FILES['filedata']['size'];


	if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploaddir . $uploadfile)) {

			if(!in_array($extension, $extensions)) {
	
				if ($tailleFichier > $tailleMax) {

				echo "Le fichier est trop gros !";

				}

			echo "Il ne s'agit pas d'un fichier png, jpeg ou jpg !";
		
			}

		echo " Téléchargement du fichier réussi !";

		else {

			echo "Erreur dans le télechagement du fichier !";
		}
	}
}
	namespace ECVChat\DB;

	function register(username, password, email) {
 
        try {


        }

        catch (Exception $e) {
            var_dump($e->getMessage());
        }
}

	function updateUserImage() {

		try {


		}

        catch (Exception $e) {
            var_dump($e->getMessage());
        }
}
?>