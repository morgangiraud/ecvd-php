<?php 
	require_once('../requires/session.php');
	if(!isset($_SESSION['username'])) {
		header("Location: login.php");
		exit();
	}

	require_once('../requires/header.php');

	require_once('../requires/functions.php');
	use Ecvdphp\User;
	use Ecvdphp\Post;

	if(isset($_GET['id'])) {

		$user = User::getUser();
		$post = Post::getPostById($user['id'], $_GET['id']);

		if(isset($_POST) && isset($_POST['delete_post'])) {
			Post::deletePost($_GET['id']);

		} else if(!$post) {
			echo "This post doesn't exist.";
		} else { 
			if($post['image_id'] !== null) $picture = User::getFileById($post['image_id']);

		?>
			<a href="index.php">Retour sur les posts</a>
			<h1><?=$post['title']?></h1>

			<p><?=$post['body']?></p>

			<?php if($post['image_id'] !== null) { ?>
				<img src="<?=$picture['path']?><?=$picture['filename']?>" width="150" alt="">
			<?php } ?>

			<a href="edit.php?id=<?=$_GET['id']?>">Edit this post</a>

			<form action="post.php?id=<?=$_GET['id']?>" style="border:none;" method="post">
				<input type="hidden" name="delete_post" />
				<button>Delete this post</button>
			</form>

		<?php 
		}

	} else {
		echo "Please put a post ID in the URL.";
	}

	require_once('../requires/footer.php');
?>
