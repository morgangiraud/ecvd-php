<?php session_start(); ?>
<?php session_regenerate_id(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>

<body>


    
    <?php if($_SESSION["logged"]): ?>
    
    
        <p>Vous êtes connecté.</p>
    
    <?php elseif($_POST["username"] && $_POST["password"]):
    
        $handle = fopen("users.txt", "r");
    echo 'handle';
        if ($handle) {
            
            $connected = false;
            while (($line = fgets($handle)) !== false) {
                $credentials = explode('/', $line);
                
                if(true){
//                if($credentials[0] == $_POST["username"] && $credentials[1] == $_POST["password"]){
                    $connected = true;
                    $_SESSION["logged"] = true;
                    $_SESSION["username"] = $_POST["username"];
                    ?>
                    
                    <p>Vous êtes connecté.</p>
                    
                    <?php                    
                }
            }
            
            
            
            header('Location: index.php');
            

            fclose($handle);
        } else {
            // error opening the file.
        } 
    
        
        ?>
        
        
        
    <?php else : ?>
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
        <a href="registration.php">Registration</a>
    <?php endif; ?>

</body>

</html>