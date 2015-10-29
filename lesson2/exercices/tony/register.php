<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
</head>

<body>


    
    
    <?php if($_POST["username"] && $_POST["password"]):
    
        $file = 'users.txt';
        // Une nouvelle personne à ajouter
        $username = $_POST["username"];
        $password = $_POST["password"];
        // Ecrit le contenu dans le fichier, en utilisant le drapeau
        // FILE_APPEND pour rajouter à la suite du fichier et
        // LOCK_EX pour empêcher quiconque d'autre d'écrire dans le fichier
        // en même temps
        file_put_contents($file, $_POST["username"] . "/", FILE_APPEND | LOCK_EX);
        file_put_contents($file, $_POST["password"] . PHP_EOL, FILE_APPEND | LOCK_EX);
       
        header('Location: index.php');
    ?>
        
    <?php else : ?>
        <h1>Registration</h1>
        <form action="" method="post">

            <input type="text" placeholder="Username" name="username">
            <br>
            <input type="password" placeholder="Password" name="password">
            <br>
            <br>
            <input type="submit" value="Connect">

        </form>
        <br>
        <a href="index.php">Connexion</a>
    <?php endif; ?>
    
    
<!--    <?php var_dump($_SESSION); ?>-->

</body>

</html>