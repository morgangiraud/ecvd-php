<?php
require_once 'session.php';
require_once 'connect.php';

require_once 'functions.php';



$message = "";
if(isset($_SESSION['id'])){
  echo "<p>{$_SESSION['username']}: you are logged in!</p>";
  $title = "Menu";
  include 'header.php';
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
    $username = ecvdphp\sanitizeString($_POST['username']); // To improve the ux of the user, you can trim the input
    $password = ecvdphp\sanitizeString($_POST['password']);

    try {
      $user = ecvdphp\DB\login($username, $password);

      $_SESSION['id'] = $user["id"];
      $_SESSION['username'] = $user["username"];
      if($user["photo_id"]){
        $_SESSION['photo_id'] = $user["photo_id"];
      }

      ecvdphp\addFlashMessage('success', 'You\'ve successfully logged in');
      ecvdphp\redirect("index.php");
    } catch (Exception $e) {
      ecvdphp\addFlashMessage('error', '<p>' . $e->getMessage() . '</p>');
    }
  }
  $title = "Login page";
  include 'header.php';
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