<?php session_start(); ?>
<?php session_regenerate_id();

    
    if( $_SESSION["logged"] ) {
    
        echo 'Vous êtes connecté.';
    
    } elseif( $_POST["username"] && $_POST["password"] ) {
        
        $handle = fopen("users.txt", "r");
        
        if ($handle) {
            
            
            while (($line = fgets($handle)) !== false) {
                $credentials = explode('/', $line);
                if($credentials[0] == $_POST["username"] && rtrim($credentials[1]) == $_POST["password"]){
                    
                    $_SESSION["logged"] = true;
                    $_SESSION["username"] = $_POST["username"];                   
                    
                }
            }
            
            fclose($handle);
            header('Location: index.php');
                
        } else {
            // error opening the file.
        }
        
        
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
    <?php } ?>

</body>

</html>