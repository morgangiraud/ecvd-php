<?php 

require('session.php');

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
</head>
<body>

    <h3>CONNECT to <?php echo $_SESSION['login_user'] ?></h3>

</body>
</html>

<form action="/" method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" />
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" />
    </div>

        <div class="button">
        <button type="submit">Valider</button>
    </div>
</form>



<form enctype="multipart/form-data" action="upload.php" method="post">
    <div>
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
      <input name="filedata" type="file" /><br />
      <input name="txt" type="text"/><br />
      <input type="submit" value="Send file" />
    </div>
</form>