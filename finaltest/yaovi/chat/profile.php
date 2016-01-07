<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<div>
  <form enctype="multipart/form-data" action="upload.php" method="post">
    <fieldset>
      <legend>Your personal information</legend>
      <p>
        <img width=120 src=""><br>
        <label for="filedata">Picture :</label>
        <input type="file" />
        <br>
        <label for="file-url">Picture URL :</label>
        <input size="64" type="text" />

        <input type="submit" value="Send file" />
      </p>
    </fieldset>
  </form>
  <div class="error"></div>
  <a href="logout.php">Log out!</a>
  <a href="chat.php">Go to the chat!</a>
</div>
</body>
</html>