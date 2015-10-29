<?php
	session_start();
	session_regenerate_id();

	if(isset($_SESSION['name'])){
		echo ('Deja connecte <br> <a href="logout.php">Logout</a>');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP</title>
</head>
<body>
	<h1>Hello World</h1>

	<form method="post" action="">
		<label>Nom</label>
		<input name='name' type='text' id='name'/>
		<br>
		<label>Mot de passe</label>
		<input type='password' name='password' id='password' />
		<br>
		<input type='submit' value='Connexion' />
	</form>

<br><br>
<?php
	echo('Nom : '.$_POST['name']);
	echo('<br>');
	echo('Mot de passe : '.$_POST['password']);
	echo('<br>');

	function return_bytes($val) {
	    $last = strtolower($val[strlen($val)-1]);
	    switch($last) {
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }
	    return $val;
	}

	$file = 'users.txt';
	$memory = return_bytes(ini_get('memory_limit'));
	$size = filesize($file);	

	if($_SERVER['REQUEST_METHOD'] === "POST"){

		if(empty($_POST['name']) || empty($_POST['password']) ){

			echo('Champ non rempli');

		}else{

			if($memory/2 > $size){
				$datas = file_get_contents($file);
				$user = explode(';', $datas);

				$key = 0;
				while (count($user) > $key) {
					$data = explode( ',', $user[$key]);

					if($_POST['name'] === $data[0] && $_POST['password'] === $data[1]){
						$_SESSION['name'] = $data[0];
						echo ('Connecte ! ');
						echo('<br>');
						echo ('<a href="logout.php">Logout</a>');
					}
					else{
						echo('Erreur');
						echo('<br>');
					}
					$key++;
				}

			}else{
				$handle = fopen($file, 'r');
				$datas = fread($handle, $size);
				$user = explode(';', $datas);

				while(!feof($handle)) {
					$data = explode( ',', $user[$key]);
				}

				if($_POST['name'] === $data[0] && $_POST['password'] === $data[1]){
					$_SESSION['name'] = $data[0];
					echo ('Connecte ! ');
					echo('<br>');
					echo ('<a href="logout.php">Logout</a>');
				}
				else{
					echo('Erreur');
					echo('<br>');
				}
				fclose($handle);
			}
		}

	}else{

		echo ('Non connecte.');

	}

?>

</body>
</html>