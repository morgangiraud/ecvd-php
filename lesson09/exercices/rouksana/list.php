<?php
	require_once('function.php');

	$posts = Blog\getAllPosts();
	include('header.php');
?>
	<h1>Posts</h1>
	<a href="blog.php">Blog</a>

		<?php
			foreach ($posts as $post):
				$image = $post['path'] . $post['filename'] . "." . $post['extension'];
		?>
			<div>
				<h2><?php echo $post['title'] ?></h2>
				<p><?php echo $post['body'];?></p>
				<?php if($post['filename'] != null):?>
					<img src="<?php echo $image;?>">
				<?php endif;?>
				<p>Created at <?php echo $post['date'];?> by <?php echo $post['name'];?> </p>
			</div>

		<?php endforeach;?>


<?php include('footer.php');?>