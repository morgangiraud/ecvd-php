<?php session_start();


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
    
    if($_POST["username"] && $_POST["password"]):

        $file = 'users.txt';
        // Une nouvelle personne à ajouter
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $query = "INSERT INTO users VALUES (null, '$username', '$email', '$password')";


        try{
            $result = $conn->query($query);
        } catch (\PDOException $e){
            echo $e->getMessage();
        }



        $_SESSION["logged"] = true;
        $_SESSION["username"] = $_POST["username"];

        header('Location: index.php');
        exit;
        echo 'test';
        
    else : ?>
       
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <title>Registration</title>
        </head>

        <body>
        <h1>Registration</h1>
        <form action="" method="post">

            <input type="text" placeholder="Username" name="username">
            <br>
            <input type="email" placeholder="Email" name="email">
            <br>
            <input type="password" placeholder="Password" name="password">
            <br>
            <br>
            <input type="submit" value="Register">

        </form>
        <br>
        <a href="index.php">Connexion</a>
        
    <?php endif; ?>

</body>

</html>