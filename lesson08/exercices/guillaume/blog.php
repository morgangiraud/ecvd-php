<?php require_once('session.php');
if(!isset($_SESSION['username'])) {
	header("Location: first.php");
	exit();
}
?>

<?php 

if(isset($_GET['id'])) {

	require_once('connect.php');

	try {
		$response = $bdd->prepare("SELECT * FROM `users` WHERE `username` = :username");
		$response->bindParam(':username', $_SESSION['username'], \PDO::PARAM_STR);
		$response->execute();
		$user = $response->fetch();
	} catch(Exception $e) {
		die('error');
	}

	try {
		$response = $bdd->prepare("SELECT * FROM `posts` WHERE `user_id` = :user_id AND `id` = ".$_GET['id']);
		$response->bindParam(':user_id', $user['id'], \PDO::PARAM_STR);
		$response->execute();
		$post = $response->fetch();
	} catch(Exception $e) {
		die('error');
	}

	if(!$post) {
		echo "Ce post n'existe pas";
	} else { 

		if($post['image_id'] !== null) {
			$response = $bdd->prepare("SELECT * FROM `files` WHERE `id` = :id");
			$response->bindParam(':id', $post['image_id'], \PDO::PARAM_STR);
			$response->execute();
			$picture = $response->fetch();
		}


		?>


		<h1><?=$post['title']?></h1>

		<p><?=$post['body']?></p>

		<?php if($post['image_id'] !== null) { ?>
			<img src="<?=$picture['path']?><?=$picture['filename']?>" width="150" alt="">
		<?php } ?>

	<?php }
} else {
	echo "Veuillez mettre un id de post dans l'url";
}


?>
