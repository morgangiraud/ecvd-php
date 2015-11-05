<?php session_start(); ?>


    <?php session_regenerate_id();

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

        <p>Vous êtes connecté.</p>
        <br>
        <a href="logout.php">Logout</a>

        <?php
    } elseif( $_POST["username"] && $_POST["password"] ) {
        
        $filesize = filesize("users.txt"); // Lecture fichier entier
        
        if( $filesize < return_bytes(ini_get('memory_limit')) / 2 ) {
            
            $fileString = file_get_contents("users.txt");
            echo $fileString;
            
        } else { // Lecture fichier ligne par ligne
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
                exit;

            } else {
                // error opening the file.
            }
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