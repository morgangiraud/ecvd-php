<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

$title = "Login page";
include 'header.php';

$message = "";
if(isset($_SESSION['id'])){
  echo "<p>{$_SESSION['username']}: you are logged in!</p>";
?>
<a href="profile.php">My profile</a>
<br>
<a href="logout.php">Logout</a>
<?php
  exit();
} else if($_SERVER['REQUEST_METHOD'] === "POST"){
  if (empty($_POST['username']) || empty($_POST['password']) ) {
    ecvdphp\addFlashMessage('error', 'Something went wrong. You must fill all the fields');
  } else {
    $username = trim($_POST['username']); // To improve the ux of the user, you can trim the input
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if($stmt->execute(array($username))){
      $result = $stmt->fetchAll();      
      if(count($result) === 1 && password_verify($password, $result[0]['password'])) {
        $_SESSION['id'] = $result[0]["id"];
        $_SESSION['username'] = $result[0]["username"];

        ecvdphp\addFlashMessage('success', 'You\'ve successfully logged in');

        ecvdphp\redirect($_SERVER['PHP_SELF']);
      }
    }
    ecvdphp\addFlashMessage('error', 'Something went wrong. You must fill all the fields');
  }
}
?>
  <div>
    
    <form method="post" action="">
      <fieldset>
        <legend>Connexion</legend>
        <p>
          <label for="username">Pseudo :</label>
          <input name="username" type="text" id="username" /><br />

          <label for="password">Mot de Passe :</label>
          <input type="password" name="password" id="password" />
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Login" />
      </p>
    </form>
    <div class="error"><?php echo $message; ?></div>
    <a href="signin.php">Sign in!</a>
  </div>
<?php
include 'footer.php';