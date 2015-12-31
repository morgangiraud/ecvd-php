<?php
	require_once ('session.php');
	require_once('function.php');

	$posts = Blog\getAllPosts();

	include('header.php');
?>
	<h1>Blog</h1>

	<?php if(isset($_SESSION['name'])): ?>
		<a href="post.php">Create a post</a>
	<?php endif;?>

	<?php if($posts != null):?>

		<h3>Liste des posts</h3>

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

		<a href="list.php">Show all posts</a>

	<?php endif;?>
	
<?php include('footer.php');?>