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

			if($post['image_id'] !== null) {
				$picture = User::getFileById($post['image_id']);
			}

		?>
			<h1><?=$post['title']?></h1>

			<p><?=$post['body']?></p>

			<?php if($post['image_id'] !== null) { ?>
				<img src="<?=$picture['path']?><?=$picture['filename']?>" width="150" alt="">
			<?php } ?>

		<?php 
		}

	} else {
		echo "Veuillez mettre un id de post dans l'url";
	}

	require_once('../requires/footer.php');
?>
