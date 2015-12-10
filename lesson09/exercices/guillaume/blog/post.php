<?php 
	require_once('../requires/session.php');
	if(!isset($_SESSION['username'])) {
		header("Location: login.php");
		exit();
	}

	require_once('../requires/header.php');

	require_once('../requires/functions.php');
	use Ecvdphp\User;

	if(isset($_GET['id'])) {

		$user = User::getUser();
		$post = User::getPostById($user['id'], $_GET['id']);

		if(isset($_POST) && isset($_POST['delete_post'])) {

			User::deletePost($_GET['id']);

		} else if(!$post) {
			echo "Ce post n'existe pas";
		} else { 

			if($post['image_id'] !== null) $picture = User::getFileById($post['image_id']);

		?>
			<a href="index.php">Retour sur les posts</a>
			<h1><?=$post['title']?></h1>

			<p><?=$post['body']?></p>

			<?php if($post['image_id'] !== null) { ?>
				<img src="<?=$picture['path']?><?=$picture['filename']?>" width="150" alt="">
			<?php } ?>

			<a href="edit.php?id=<?=$_GET['id']?>">Modifier ce post</a>

			<form action="post.php?id=<?=$_GET['id']?>" method="post">
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
