<?php 

require('function.php');
	
?>
<h1>ALL POSTS</h1>

<div class="posts">
		<div class="post">
			<h2><?php echo $_POST['title'] ?></h2>
			<p><?php echo $_POST['body'] ?></p>
			<span><?php echo $_POST['created_at'] ?></span>
		</div>
	<?php
		}
	?>
