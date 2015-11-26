<html>
<?php
$login_t = "manou";
$password_t = "root";
$mesage = '';

if (!empty($_POST))
{
	if (empty($_POST['login'])){
		$message = 'login Please';
	}
	else if(empty($_POST['password'])){
		$message = 'mot de passe erroné';	
	}
	else if($_POST['login'] !== $login_t){
		$message = 'Votre login est faux';
	}
	else if ($_POST['password'] !== $password_t){
		$mesage = 'Votre mot de passe est faux';

	}
	else
	{
		$message = 'Bienvenue '. $_POST['login'].' !'; 
	}
	echo $message;
}
?>
<body>
<form method="post" action="index.php">
<label for="login">login:</label>
<input type="text"  id="login" value="" name="login" /><br><br>
<label for="password">Password:</label>
<input type="password" type="text" id="password" value="" name="password" />
<p>
<input type="submit" value="Envoyer" />
</p>


</form>
</body>
</html>
