<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>
<?php
session_start();
session_regenerate_id();

$user_id = '1';
$Username="root";
$Photo_id= '1';

if (isset($_POST['id']) && isset($_POST['username']) && isset($_POST['photo_id'])) {
  if ($user_id == $_POST['id'] && $Username == $_POST['username'] && $Photo_id == $_POST['photo_id']) {
    $_SESSION['id'] = $_POST['id'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['photo_id'] = $_POST['photo_id'];

    header('location:/index.php');
  }
  else{
    echo "Alert it's wrong";
  }
}
  //else{
    //echo "les variables sont déclarées";
  //}
?>
<div>
  <form method="post" action="">
    <fieldset>
      <legend>Connexion</legend>
      <p>
        <label>Username :</label>
        <input typse="text" /><br />

        <label>Password :</label>
        <input type="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Login" />
    </p>
  </form>
  <div class="error"></div>
  <a href="signin.php">Sign in!</a>
</div>
</body>
</html>