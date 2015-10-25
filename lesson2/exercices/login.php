<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <div>
    <?php
      $message = "";
      if(isset($_SESSION['id'])){
        echo '<p>You are logged in!</p>';
        echo '<a href="logout.php">Logout</a>';
        exit();
      } else if($_SERVER['REQUEST_METHOD'] === "POST"){
        if (empty($_POST['pseudo']) || empty($_POST['password']) ) {
          $message = '<p>Something went wrong. You must fill all the fields</p>';
        } else {
          $pseudo = $_POST['pseudo'];
          $password = $_POST['password'];

          $credentials = [
            'id' => 2,
            'pseudo' => 'john',
            'password' => 'pass'
          ];

          if($pseudo === $credentials['pseudo'] && $password === $credentials['password']){
            $_SESSION['id'] = $credentials['id'];
            header('Location: ' . $_SERVER['PHP_SELF'], true, 301);
            exit();
          } else {
            $message = '<p>Something went wrong. Username or password is wrong</p>';
          }
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
    <div class="error"><?php echo $message; ?></div>
  </div>
</body>
</html>