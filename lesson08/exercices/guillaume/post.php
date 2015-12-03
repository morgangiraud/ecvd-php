<?php require_once('session.php');

?>

<?php

	require_once('functions.php');
	use Ecvdphp\User;
	
	if(isset($_POST) && isset($_POST['post_article'])) {

		$title = $_POST['title'];
		$body = $_POST['body'];

		$picture = User::checkFile();

		if(!is_array($picture)) {
			$picture = null;
		} else {
			$picture =  User::moveFile($picture, 'post');
		}

		$date = date_format(date_create(), 'Y-m-d H:i:s');

		require_once('connect.php');

		$user = User::getUser()[0];

		try {
			$insert = $bdd->prepare("
				INSERT INTO `posts` (`title`, `body`, `user_id`, `image_id`, `created_at`) 
				VALUES 				(:title, :body, :user_id, :image_id, :created_at)
			");

			$insert->bindParam(':title', $title, \PDO::PARAM_STR);
			$insert->bindParam(':body', $body, \PDO::PARAM_STR);
			$insert->bindParam(':user_id', $user['id'], \PDO::PARAM_INT);
			$insert->bindParam(':image_id', $picture, \PDO::PARAM_INT);
			$insert->bindParam(':created_at', $date, \PDO::PARAM_STR);
			$insert->execute();

			print_r($insert->errorInfo());

		} catch (Exception $e) {
			die("Some error occured while the register process : ".$e);
		}
	}

?>

<h1>Ecrire un article</h1>

<form action="post.php" method="post" enctype="multipart/form-data">

	<input type="hidden" name="post_article" />

	<div class="style_input">
		<label for="title">Title</label>
		<input type="text" name="title" required />
	</div>

	<div class="style_input">
		<label for="body">Content</label>
		<textarea type="text" name="body" required></textarea>
	</div>

	<input type="file" name="filedata" />

	<button>Add Post</button>
	
</form>