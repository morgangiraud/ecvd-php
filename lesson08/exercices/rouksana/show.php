<?php
	require_once ('session.php');
	require_once('function.php');
	$posts = Blog\getAllPosts();
	

	if(!isset($_GET['post'])){
		User\redirect('index.php');
	}
	
	if(isset($_SESSION['name'])){
		$user = User\getUser($_SESSION['name']);
	}

	$post = Blog\getPost($_GET['post']);
	$image = $post['path'] . $post['filename'] . "." . $post['extension'];


	if(isset($_POST['delete_post'])) {
		Blog\deletePost($post['id']);
		User\redirect('index.php');
	}

	include('header.php');
?>
	<h1><?php echo $post['title'];?></h1>
	<p><?php echo $post['body'];?></p>
	<?php if($post['filename'] != null):?>
		<img src="<?php echo $image;?>">
	<?php endif;?>

	<p>Created at <?php echo $post['date'];?> by <?php echo $post['name'];?> </p>

	<?php if($user['id'] === $post['user_id']): ?>	

		<form method="post" action="edit.php">
			<input type="hidden" name="post_id" value="<?php echo $post['id'];?>" />
			<input type='submit' value='Edit this post' />
		</form>
		
		<form method="post" action="">
			<input type="hidden" name="delete_post" />
			<input type='submit' value='Delete this post' />
		</form>
		
	<?php endif; ?>

	<br>
	<a href="blog.php">BLOG</a>

			
<?php include('footer.php');?>