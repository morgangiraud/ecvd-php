<?php 

    session_start();
    session_regenerate_id();

    $username = "root";
    $password = "";
    $host = "127.0.0.1";
    $dbname = "ecvdphp";


    try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
    }   
    catch (\PDOException $e){
    echo $e->getMessage();
    }



?>

<!DOCTYPE html>
<html>
<head>
	<title>REGISTER</title>
    <meta charset="utf-8">
</head>
<body>



<form  method="post">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="pseudo" placeholder="Votre nom"/>
    </div>
    <br/>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" placeholder="Votre mot de passe"/>
    </div>
    <br/>
    <div>
        <label for="email">E-mail :</label>
        <input type="text" name="email" placeholder="Votre e-mail"/>
    </div>

    <input type="submit" value="Envoyer" />
</form>


<?php

/*    echo trim($_POST["pseudo"]);
    echo trim($_POST["pseudo"]);
    echo trim($_POST["email"]);*/

        $file = file("users.txt");
            if(isset($_POST['pseudo']) && empty($_POST['pseudo']) == false && isset($_POST['password']) && empty($_POST['password']) == false && isset($_POST['email']) && empty($_POST['email']) == false) {


        try{
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
        $result = $conn->query('INSERT INTO users (username, password, email) VALUES ("'.($_POST["pseudo"]).'","'. md5($_POST["password"]) .'","'. ($_POST["email"]).'")');
        }   
        catch (\PDOException $e){
        echo $e->getMessage();

        }

    }
        else {
           die('no post data to process');
        }
?>

<?php

echo md5($_POST["password"]);


?>

</body>
</html>