<?php 

require('session.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CONNECT</title>
</head>
<body>

<form enctype="multipart/form-data" action="/" method="post">
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
    <div>
      <input name="filedata" type="file" />
      <input type="submit" value="Send file" />
    </div>
</form>

    <h1>CONNECT to <?php echo $_SESSION['login_user'] ?></h1>
    <p>and your pwd is........... <?php echo $_SESSION['pwd_user'] ?></p>
</body>
</html>
