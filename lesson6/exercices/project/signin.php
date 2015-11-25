<?php
require_once 'session.php';

require_once 'connect.php';

$message = "";
if(isset($_SESSION['id'])){
  header('Location:login.php', true, 301);
  exit();
} else if($_SERVER['REQUEST_METHOD'] === "POST"){
  if (empty($_POST['pseudo']) || empty($_POST['password']) ) {
    $message = '<p>Something went wrong. You must fill all the fields</p>';
  } else {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bindParam(1, trim($pseudo));
    $stmt->bindParam(2, trim($email));
    $stmt->bindParam(3, password_hash($password, PASSWORD_BCRYPT));
    if($stmt->execute()){
      header('Location:login.php', true, 301);
      exit();
    } else {
      $message = '<p>Something went wrong. Username or password is wrong</p>';
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
          <label for="pseudo">Pseudo :</label>
          <input name="pseudo" type="text" id="pseudo" /><br />

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