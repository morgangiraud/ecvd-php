<?php 

	
	$posts = getAllPosts();
?>
<h1>ALL POSTS</h1>

<div class="posts">
	<?php
		foreach ($posts as $value) {
			$urlimg = getImage($value['image_id']);
			$user = getUserName($value['user_id']);
	?>
		<div class="post" style="margin-bottom: 50px">
			<strong>Username:<?php echo $user["username"] ?></strong><h2><?php echo $value['title'] ?></h2><a href="editPost.php?id=<?php echo $value['id'] ?>">-edit-</a>
			<a href="removePost.php?id=<?php echo $value['id'] ?>">-remove-</a><br>
			<img src='<?php echo $urlimg["path"] ?>' style='width:500px; height:300px'>
			<p><?php echo $value['body'] ?></p>
			<span><?php echo $value['created_at'] ?></span>
		</div>
	<?php
		}
	?>
</div>