<?php 
	require 'function.php';
	
	$posts = getAllPosts();
?>
<h1>ALL POSTS</h1>

<div class="posts">
	<?php
		foreach ($posts as $value) {
			$urlimg = getImage($value['image_id']);
	?>
		<div class="post">
			<h2><?php echo $value['title'] ?></h2>
			<img src='<?php echo $urlimg["path"] ?>'>
			<p><?php echo $value['body'] ?></p>
			<span><?php echo $value['created_at'] ?></span>
		</div>
	<?php
		}
	?>
</div>