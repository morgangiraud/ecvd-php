<?php
require('session.php');
?>

<h2> Profile page </h2>

<?php echo $_SESSION['login_user'] ?>

<h3> Add profile image </h3>

<form enctype="multipart/form-data" action="upload.php" method="post">
    <div>
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
      <input name="filedata" type="file" /><br />
      <input name="txt" type="text"/><br />
    </div>
    <input type="submit" value="envoyer" />
</form>

<<<<<<< HEAD
<?php

$req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5')

?>
=======
<h1> All posts </h1>
>>>>>>> 8ff652f6bd7f951a97ec542a89f2ec03ecb4051a
