<?php
require_once 'session.php';
require_once 'pdo.php';
require_once 'functions.php';

$message = "";
if(isset($_SESSION['id'])){
  ECVChat\redirect('index.php');
} else if($_SERVER['REQUEST_METHOD'] === "POST"){
  if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) ) {
    $message = '<p>Something went wrong. You must fill all the fields</p>';
  } else {
    $username = ECVChat\sanitizeString($_POST['username']);
    $email = ECVChat\sanitizeString($_POST['email']);
    $password = ECVChat\sanitizeString($_POST['password']);

    try {
      ECVChat\DB\register($username, $password, $email);

      ECVChat\redirect("index.php");
    } catch (Exception $e) {
      $message = '<p>' . $e->getMessage() . '</p>';
    }
  }
}

require_once 'header.php';
?>
<div>
  <form method="post" action="">
    <fieldset>
      <legend>Register</legend>
      <p>
        <label>Username :</label>
        <input name="username" type="text"/><br />

        <label>Email :</label>
        <input name="email" type="email"/>

        <label>Password :</label>
        <input name="password" type="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Register" />
    </p>
  </form>
  <div class="error"><?php echo isset($message) ? $message : "";?></div>
  <a href="index.php">Already have an account? Login here!</a>
</div>
<?php
require_once 'footer.php'
?>