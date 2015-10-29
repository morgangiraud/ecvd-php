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
        $file = "users.txt";
        if(isset($_POST['nom']) && isset($_POST['mdp']) && isset($_POST['email'])) {
            $data = $_POST['nom'] . '.+.' . $_POST['mdp'] . '.+.' . $_POST['email'] . "\n";
            $ret = file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
            if ($ret === false) {
                die ('There was an error writing this file');
            }
            else {
                echo "$ret";
            }
        }
        else {
           die('no post data to process');
        }
    ?>

</body>
</html>