<?php
	include_once('pdo.php');
	include_once('session.php');
	include_once('functions.php');

	if(isset($_POST['username']) and !empty($_POST['username']) and isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['password']) and !empty($_POST['password'])){
		$username = strip_tags($_POST['username']);
		$email = strip_tags($_POST['email']);
		$password = strip_tags($_POST['password']);

		$red = $conn->prepare('INSERT INTO users(username,email,password) VALUES(?,?,?)');
		$req->execute(array($username,$email,$password));
	} else{
		include_once('header.php');
?>
		<body>
			<div>
		  		<form method="post" action="signin.php">
					<fieldset>
			  			<legend>Register</legend>
			  			<p>
							<label>Username :</label>
							<input type="text" name="username" /><br />

							<label>Email :</label>
							<input type="email" name="email" />

							<label>Password :</label>
							<input type="password" name="password"/>
			  			</p>
					</fieldset>
					<p>
			  			<input type="submit" value="Register" />
					</p>
		  		</form>
		  		<div class="error"></div>
			</div>
	  </body>
<?php
	}
	include_once('footer.php');
?>