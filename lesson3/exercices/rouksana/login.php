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
	<h1>Login</h1>

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
	echo('Nom : '.$_POST['name'].'<br>');
	echo('Mot de passe : '.$_POST['password'].'<br>');

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

			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            $user = trim($name) . ',' . hash('haval256,5', trim($password)) . "\n";

			if($memory/2 > $size){

				foreach(file($file) as $data) {
                    if($data == $user) {
                        
                        $_SESSION['name'] = $_POST['name'];
                        
                   		echo ('Connecte ! <br>');
						echo ('<a href="logout.php">Logout</a>');
					}
                }
            } else {
				$handle = fopen($file, 'r');
				$datas = fread($handle, $size);
				$user = explode(';', $datas);

				while(feof($handle) != false) {
					$data = explode( ',', $user[$key]);

					$_SESSION['name'] = $_POST['name'];
					echo ('Connecte ! <br>');
					echo ('<a href="logout.php">Logout</a>');
				
				fclose($handle);
				}
			}
		}

	}else{

		echo ('Non connecte.');

	}

?>

</body>
</html>