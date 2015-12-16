<?php
	require_once ('session.php');
	require_once('function.php');
	
	if(isset($_SESSION['name'])){
		echo ('Deja connecte <br> <a href="logout.php">Logout</a> <br> <a href="profile.php">Profile</a> <br> <a href="post.php">BLOG</a>');
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

<?php
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	$users = User\getAllUsers($name, $password);

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(empty($_POST['name']) || empty($_POST['password']) ){
			echo('Champ non rempli');
		}else{
			foreach ($users as $key => $user) {
				$getname = $user['username'];
				$getpwd = $user['password'];
				if($getname == $name && $getpwd == $password){
					$_SESSION['name'] = $_POST['name'];
               		echo ('Connecte ! <br> <a href="logout.php">Logout</a> <br> <a href="profile.php">Profile</a> <br> <a href="post.php">BLOG</a>');
				}
				
            }
		}
	}
?>
<?php include('footer.php');?>