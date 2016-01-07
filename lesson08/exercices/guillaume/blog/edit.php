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

		if(!$post) {
			echo "Ce post n'existe pas";
		} else { 

			if($post['image_id'] !== null) $picture = User::getFileById($post['image_id']);
		?>

			<a href="post.php?id=<?=$_GET['id']?>">Get back on post</a>

			<form action="edit.php" method="post">
				<h2>Title</h2>
				<input type="text" value="<?=$post['title']?>">

				<h2>Content</h2>
				<textarea name="" id="" cols="30" rows="10"><?=$post['body']?></textarea>
				
				<div>
					<button>Save</button>
				</div>
			</form>

		<?php 
		}

	} else {
		echo "Please put a post id valid in the URL.";
	}

	require_once('../requires/footer.php');
?>
