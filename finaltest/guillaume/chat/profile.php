<?php require_once('requires/header.php');


if(isset($_POST['update_profile'])) {
  require_once('requires/functions.php');

  if(\ECVChat\checkUpload('filedata')) {
    $picture = \ECVChat\uploadFile($_FILES['filedata']);
    $upload = $picture[0].$picture[1];
  }
}

if(isset($upload)) {
  $pic = $upload;
} else if(isset($_SESSION['photo_url'])) {
  $pic = $_SESSION['photo_url'];
} else {
  $pic = '';
}

?>

<div>
  <form enctype="multipart/form-data" action="profile.php" method="post">

    <fieldset>
      <legend>Your personal information</legend>
      <p>
        <input type="hidden" name="update_profile">
        <img width="120" src="<?=$pic?>"><br>

        <label for="filedata">Picture :</label>
        <input type="file" name="filedata" />
        <br>

        <label for="file-url">Picture URL :</label>
        <input size="64" type="text" />

        <input type="submit" value="Send file" />
      </p>
    </fieldset>

  </form>
  <div class="error"></div>
  <a href="requires/logout.php">Log out!</a>
  <a href="chat.php">Go to the chat!</a>
</div>

<?php require_once('requires/footer.php') ?>