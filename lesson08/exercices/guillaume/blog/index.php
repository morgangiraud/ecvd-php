<?php require_once('../requires/session.php');

	require_once('../requires/header.php');

	require_once('../requires/functions.php');
	use Ecvdphp\User; 
	
	if(isset($_POST) && isset($_POST['post_article'])) {
		User::insertPost();
	}

?>

<h1>Ecrire un article</h1>

<form action="index.php" method="post" enctype="multipart/form-data">

	<input type="hidden" name="post_article" />

	<div class="style_input">
		<label for="title">Title</label>
		<input type="text" name="title" required />
	</div>

	<div class="style_input">
		<label for="body">Content</label>
		<textarea type="text" name="body" required></textarea>
	</div>
	
	<div class="style_input">
		<input type="file" name="filedata" />
	</div>

	<button>Add Post</button>
	
</form>

<?php require_once('../requires/footer.php'); ?>