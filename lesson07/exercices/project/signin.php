<?php
require_once 'session.php';
require_once 'connect.php';
require_once 'functions.php';

$message = "";
if(isset($_SESSION['id'])){
  header('Location:index.php', true, 301);
  exit();
} else if($_SERVER['REQUEST_METHOD'] === "POST"){
  if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) ) {
    $message = '<p>Something went wrong. You must fill all the fields</p>';
  } else {
    $username = ecvdphp\sanitizeString($_POST['username']);
    $email = ecvdphp\sanitizeString($_POST['email']);
    $password = ecvdphp\sanitizeString($_POST['password']);

    try {
      ecvdphp\DB\register($username, $password, $email);

      ecvdphp\redirect("index.php");
    } catch (Exception $e) {
      $message = '<p>' . $e->getMessage() . '</p>';
    }
  }
}
include 'header.php';
?>
<body>
  <div>
    <form method="post" action="">
      <fieldset>
        <legend>Register</legend>
        <p>
          <label for="username">Pseudo :</label>
          <input name="username" type="text" id="username" /><br />

          <label for="email">Email :</label>
          <input type="email" name="email" id="email" />

          <label for="password">Mot de Passe :</label>
          <input type="password" name="password" id="password" />
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Register" />
      </p>
    </form>
    <div class="error"><?php if(isset($message)) echo $message; ?></div>
  </div>
</body>
</html>