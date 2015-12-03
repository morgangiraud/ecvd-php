<?php

session_start();

require('connect.php');

if( $_SESSION["logged"] ) { ?>

    <h1>Hello <?= ucfirst($_SESSION["username"]) ?></h1>
    
    <hr>
    
    <form action="" method="post">

        <input type="text" placeholder="Username" name="username" value="<?= $_SESSION['username'] ?>">
        <br>
        <input type="email" placeholder="Email" name="email" value="<?= $_SESSION['email'] ?>">
        <br>
        <input type="password" placeholder="Password" name="password">
        <br>
        <br>
        <input type="submit" value="Update">

    </form>
    <br>
    <a href="index.php">Home</a>

<?php } else {
    
    header('Location: index.php');
    
}


if( $_POST ) { 
    var_dump($_POST);
}