<?php
require('session.php');

?>

<h2> Profile page </h2>

<p> Hello <?php echo $_SESSION['login_user'] ?></p>

<h3> Add profile image </h3>

<form enctype="multipart/form-data" action="upload.php" method="post">
    <div>
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
      <input name="filedata" type="file" /><br />
      <input name="txt" type="text"/><br />
    </div>
    <input type="submit" value="envoyer" />
</form>

<h1> All posts </h1>

<?php 

require('connect_db.php');
require('functions.php');

date_default_timezone_set('UTC');
$date = date("Y-m-d h:i:s");
        try {
        	$result = $conn->prepare('insert into posts values (null, :title, :body, 3, 2, :date)');
        	$result->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
        	$result->bindParam(":body", $_POST['body'], PDO::PARAM_STR);
        	$result->bindParam(":date", $date, PDO::PARAM_STR);
        	$result->execute();
    	} catch (Exception $e) {
        	echo $e->getMessage();
    	}

?>

<div class="posts">

<hr>

<?php 

$getPosts = userPosts();

foreach ($getPosts as $value) {

?>

	<h2><?php echo $_POST["title"];?></h2>
	<p><?php echo $_POST["body"];?></p>
	<?php echo $_POST["filedata"];?>

<?php
}
?>



<hr>

</div>
