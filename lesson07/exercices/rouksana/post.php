<?php
	require_once ('session.php');
	require_once('function.php');

	if(!isset($_SESSION['name'])){
		User\redirect('index.php');
	}

	$user = User\getUser($_SESSION['name']);
	$id = filter_var($user['id'], FILTER_SANITIZE_STRING);


	if(isset($_POST['create_post'])) {
		Blog\createPost($_POST['title'], $_POST['body'], $id);
		User\redirect('blog.php');
	}

	include('header.php');
?>
	<h1>Create a post</h1>
	<h2>Hello <?php echo $_SESSION['name']; ?> !</h2>

	<form method="post" action="">
		<label>Tilte</label>
		<input type='text' name='title' id='title'/>
		<br>
		<label>Body</label>
		<textarea name="body" rows="5" cols="15"></textarea>
		<br>
		<label>Image</label>
		<input type='file' name='image' id='image' />
		<br>
		<input type='hidden' name='id' value="<?php echo $id;?>">
		<input type="hidden" name="create_post" />
		<input type='submit' value='Create post' />
	</form>

<?php include('footer.php');?>