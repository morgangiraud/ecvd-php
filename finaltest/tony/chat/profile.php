<?php

require_once('session.php');
require_once('pdo.php');
require_once('functions.php');


$userPhotoUrl = getUserPhotoUrl($_SESSION['id']);

?>

<form enctype="multipart/form-data" action="upload.php" method="post">
  <fieldset>
    <legend>Your personal information</legend>
    <p>
      <img width=120 src="<?= $userPhotoUrl ?>"><br>
      <label for="filedata">Picture :</label>
      <input type="file" name="userfile" id="userfile"/>
      <br>
      <label for="file-url">Picture URL :</label>
      <input size="64" type="text"  name="userfileurl" id="userfileurl"/>
      <input type="submit" value="Send file" />
    </p>
  </fieldset>
</form>
<div class="error"></div>
<a href="logout.php">Log out!</a>
<a href="chat.php">Go to the chat!</a>
