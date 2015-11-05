<?php 
    session_start();
    session_regenerate_id();
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
        <input type="text" name="nom" placeholder="Votre nom"/>
    </div>
    <br/>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" name="mdp" placeholder="Votre mot de passe"/>
    </div>
    <br/>
    <div>
        <label for="email">E-mail :</label>
        <input type="text" name="email" placeholder="Votre e-mail"/>
    </div>

    <input type="submit" value="Envoyer" />
</form>


<?php

    echo trim($_POST["nom"]);
    echo trim($_POST["mdp"]);
    echo trim($_POST["email"]);

        $file = file("users.txt");
            if(isset($_POST['nom']) && empty($_POST['nom']) == false && isset($_POST['mdp']) && empty($_POST['mdp']) == false && isset($_POST['email']) && empty($_POST['email']) == false) {
            $data = $_POST['nom'] . '.+.' . $_POST['mdp'] . '.+.' . $_POST['email'] . "\n";
            var_dump($file);
            foreach($file as $line) {

                if($line == $data) {
                    echo $data . " is in the users.txt";
                    
                    $_SESSION['login_user']=$_POST['nom'];
                    $_SESSION['pwd_user']=$_POST['mdp'];

                    //header('Location: connect.php');
                     exit;
                }
            }
        }
        else {
           die('no post data to process');
        }
?>


</body>
</html>