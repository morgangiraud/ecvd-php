<?php
require('session.php');
?>

<h2> Profile page </h2>

<?php echo $_SESSION['login_user'] ?>

<h3> Add profile image </h3>

<form enctype="multipart/form-data" action="upload.php" method="post">
    <div>
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
      <input name="filedata" type="file" /><br />
      <input name="txt" type="text"/><br />
    </div>
    <input type="submit" value="envoyer" />
</form>