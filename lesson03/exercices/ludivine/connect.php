<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CONNECT</title>
</head>
<body>
    <h1>CONNECT to <?php echo $_SESSION['login_user'] ?></h1>
    <p>and your pwd is........... <?php echo $_SESSION['pwd_user'] ?></p>
</body>
</html>
