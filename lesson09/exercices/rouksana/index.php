<?php
	require_once ('session.php');
	require_once('function.php');

	if($_SERVER['REQUEST_METHOD'] === "POST"){
		if(empty($_POST['name']) || empty($_POST['password']) ){
			echo('Champ non rempli');
		}else{
			User\insert($_POST['name'], $_POST['password'], $_POST['email']);
		}	
	}
	$posts = Blog\getAllPosts();
	include('header.php');
?>
	<h1>Register</h1>

	<form method="post" action="">
		<label>Nom</label>
		<input name='name' type='text' id='name'/>
		<br>
		<label>E-mail</label>
		<input type='email' name='email' id='email' />
		<br>
		<label>Mot de passe</label>
		<input type='password' name='password' id='password' />
		<br>
		<input type='submit' value='Register' />
	</form>
	<br>
	<a href="login.php">Login</a>
	<br>

	<?php if($posts != null):?>

		<h2>Liste des posts</h2>

			<table border="1" width="500px">
				<tr style="font-weight:bold;">
					<td>Titre</td>
					<td>Auteur</td>
					<td>Date</td>
					<td>Voir</td>
				</tr>
			<?php foreach ($posts as $post):?>
				<tr>
					<td><?php echo $post['title'];?></td>
					<td><?php echo $post['name'];?></td>
					<td><?php echo $post['date'];?></td>
					<td><a href="show.php?post=<?php echo $post['id'];?>">Voir ce post</a></td>
				</tr>
			<?php endforeach;?>
			</table>

	<?php endif;?>
<?php include('footer.php');?>