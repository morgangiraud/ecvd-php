<form method="post">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" placeholder="Votre nom"/>
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" name="mdp" placeholder="Votre mot de passe"/>
    </div>
    <div>
        <label for="email">E-mail :</label>
        <input type="text" name="email" placeholder="Votre e-mail"/>
    </div>


    <input type="submit" value="Envoyer" />
</form>

<?php

require('session.php');
require('functions.php');

?>
