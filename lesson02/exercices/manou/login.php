<?php
session_start();
session_regenerate_id();
?>
<! DOCTYPE html>
<html>
<head>
  <title></title>
  </head>
  <body>
    <?php
    echo ('nom : '.$_POST['pseudo']);
    echo ('<br>');
    echo ('mot de passe : '.$_POST['password']);
    echo ('<br>');

    $users = file('users.txt');
    if ($_SESSION['pseudo']);
      echo ('Vosu etes connecté');
      echo ('<br>');
      echo ('<a href="logout.php">Logout</a>');
    }else if ($_SERVER['REQUEST_METHOD'] === "POST"){
      if (empty($_POST["pseudo"]) || empty($_POST['password'])){
        echo('champ vide');
    }else{
      
      }
    }


    ?>
 <form method="post" action="">
      <fieldset>
        <legend>Connexion</legend>
        <p>
          <label for="pseudo">Pseudo :</label>
          <input name="pseudo" type="text" id="pseudo" /><br />

          <label for="password">Mot de Passe :</label>
          <input type="password" name="password" id="password" />
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Login" />
      </p>
    </form>
  </body>
</html>