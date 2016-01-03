<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CONNECT</title>
</head>
<body>
    <h1>CONNECT to <?php echo $_SESSION['login'] ?></h1>
    <p>and your pwd is........... <?php echo $_SESSION['password'] ?></p>
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
      <input name="filedata" type="file" />
      <input type="submit" value="Send file" />
    </div>
</form>