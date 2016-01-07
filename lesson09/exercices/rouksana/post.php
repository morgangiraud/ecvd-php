<?php
	require_once ('session.php');
	require_once('function.php');

	if(!isset($_SESSION['name'])){
		User\redirect('index.php');
	}

	$user = User\getUser($_SESSION['name']);
	$id = filter_var($user['id'], FILTER_SANITIZE_STRING);


	if(isset($_POST['create_post'])) {
		if(empty($_POST['title']) || empty($_POST['body']) ){
			echo('Champ non rempli');
		}else{
			$post_id = Blog\createPost($_POST['title'], $_POST['body'], $id);

			if(isset($_FILES['file'])) {

				list($name, $extension) = User\uploadFile($_FILES['file']['name'], $_FILES['file']['tmp_name']);

				$path = 'upload/';
				$image_id = Blog\updatePostImage($post_id, $name, $path, $extension);
			}

			User\redirect('show.php?post='.$post_id);
		}
	}
		
	include('header.php');
?>
	<h1>Create a post</h1>

	<form method="post" action="" enctype="multipart/form-data">
		<label>Tilte</label>
		<input type='text' name='title' id='title'/>
		<br>
		<label>Body</label>
		<textarea name="body" rows="5" cols="15"></textarea>
		<br>
		<label>Image</label>
		<input type='file' name='file'>
		<br>
		<input type='hidden' name='id' value="<?php echo $id;?>">
		<input type="hidden" name="create_post" />
		<input type='submit' value='Create post' />
	</form>

<?php include('footer.php');?>