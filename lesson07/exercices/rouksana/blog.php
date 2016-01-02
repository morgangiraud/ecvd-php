<?php
	require_once ('session.php');
	require_once('function.php');

	if(!isset($_SESSION['name'])){
		User\redirect('index.php');
	}

	$user = User\getUser($_SESSION['name']);

	$posts = Blog\getAllPosts();

	include('header.php');
?>
	<h1>Blog</h1>
	<h2>Hello <?php echo $_SESSION['name']; ?> !</h2>

	<a href="post.php">Create a post</a>

	<h3>Liste des posts</h3>

		<table border="1" width="500px">
			<tr style="font-weight:bold;">
				<td>Titre</td>
				<td>Auteur</td>
				<td>Date</td>
			</tr>
		<?php foreach ($posts as $post):?>
			<tr>
				<td><?php echo $post['title'];?></td>
				<td><?php echo $post['username'];?></td>
				<td><?php echo $post['created_at'];?></td>
			</tr>
		<?php endforeach;?>
			
		</table>
	
<?php include('footer.php');?>