<?php
	require_once ('session.php');
	require_once('function.php');

	$name = $_SESSION['name'];

	if(!isset($name)){
		User\redirect('index.php');
	}

	$user = User\getUser($name);
	$id = filter_var($user['id'], FILTER_SANITIZE_STRING);


	if(isset($_POST['create_post'])) {
		include('connect.php');
		$body = filter_var($_POST['body'], FILTER_SANITIZE_STRING);
	    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
	    $date = now();

		$stmt = $conn->prepare('INSERT INTO posts (id, title, body, user_id, image_id, created_at) VALUES (null, :title, :body, :id, null, :date)');
		$stmt->bindParam(':title', $title, PDO::PARAM_STR);
		$stmt->bindParam(':body', $body, PDO::PARAM_STR);
		$stmt->bindParam(':user_id', $id, PDO::PARAM_STR);
		$stmt->bindParam(':date', $date, PDO::PARAM_STR);
		$stmt->execute();

	}

	include('header.php');
?>
	<h1>Blog</h1>
	<h2>Hello <?php echo $name; ?> !</h2>

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