<?php
	require_once ('session.php');
	require_once('function.php');
	use Php\Helper;
	
	if(isset($_SESSION['name'])){
		echo ('Deja connecte <br> <a href="logout.php">Logout</a>');
	}
	include('header.php');
?>
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
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	echo('Nom : '.$name.'<br>');
	echo('Mot de passe : '.$password.'<br>');

	$users = Helper::getAllUsers($name, $password);

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(empty($_POST['name']) || empty($_POST['password']) ){
			echo('Champ non rempli');
		}else{
			foreach ($users as $key => $user) {
				$getname = $user['username'];
				$getpwd = $user['password'];
				if($getname == $name && $getpwd == $password){
					$_SESSION['name'] = $_POST['name'];
                        
               		echo ('Connecte ! <br>');
					echo ('<a href="logout.php">Logout</a><br>');
					echo ('<a href="profile.php">Profile</a>');
				}
				else{
					echo ('Error');
				}
            }
		}
	}else{
		echo ('Non connecte.');
	}
?>
<?php include('footer.php');?>