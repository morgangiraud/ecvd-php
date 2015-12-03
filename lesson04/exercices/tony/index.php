<?php session_start(); ?>


    <?php session_regenerate_id();
    
    $host = "127.0.0.1";
    $dbname = "ecvdphp";
    $user = "tony";
    $pass = "tonylucas";

    try{
      $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Activate exception
    } catch (\PDOException $e){
      echo $e->getMessage();
    }

    



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
        

        $result = $conn->query('SELECT * FROM users');
        
        foreach  ($result as $row) {
            if($row['username'] == $_POST["username"] && $row['password'] == $_POST["password"]) {
                $_SESSION["logged"] = true;
                $_SESSION["username"] = $_POST["username"];
                header('Location: index.php');
                exit;
            }
            
        }
        
        header('Location: register.php');
        exit;
        
        
        
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