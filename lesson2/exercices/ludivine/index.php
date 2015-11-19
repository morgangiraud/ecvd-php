<?php session_start() ?>

<!DOCTYPE html>
<html>
<head>
	<title>test</title>
    <meta charset="utf-8">
</head>
<body>

<?php

$mdp="213";
$nom="Ludivine";


if ((($_POST["nom"]==$nom) && ($_POST["mdp"]==$mdp)) || isset($_SESSION["nom"])) {
 
    echo "Vous êtes connecté !";
    $_SESSION['nom'] = $_POST['nom'];
    $_SESSION['mdp'] = $_POST['mdp'];
}
else {
?>

<form action="/" method="post">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" placeholder="Votre nom"/>
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" name="mdp" placeholder="Votre mot de passe"/>
    </div>

    <input type="submit" value="Envoyer" />
</form>
<?php
}
?>

</body>
</html>