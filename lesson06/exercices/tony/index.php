<?php

require('session.php');
require('connect.php');


function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // Le modifieur 'G' est disponible depuis PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}


if( $_SESSION["logged"] ) { ?>

    <p>Vous êtes connecté.
        <br>
        <a href="profile.php">Profile</a>
    </p>

    <a href="logout.php">Logout</a>

    <?php
} elseif( $_POST["username"] && $_POST["password"] ) {


    $stmt = $conn->prepare('SELECT username, email, id
        FROM users
        WHERE username = ?
        AND password = ?'
    );

    $stmt->execute(array($_POST["username"], $_POST["password"]));
    $result = $stmt->fetchAll();
    if(count($result) > 0) {
        $_SESSION["logged"] = true;
        $_SESSION["username"] = $result[0]['username'];
        $_SESSION["email"] = $result[0]['email'];
        $_SESSION["userId"] = $result[0]['id'];
        header('Location: index.php');
        exit;
    }

    redirect('register.php');


} else { ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <title>Connexion</title>
        </head>

        <body>
            <h1>Connexion</h1>
            <form action="" method="post">

                <input type="text" placeholder="Username" name="username">
                <br>
                <input type="password" placeholder="Password" name="password">
                <br>
                <br>
                <input type="submit" value="Connect">

            </form>
            <br>
            <a href="register.php">Registration</a>
<?php }

require('footer.php');