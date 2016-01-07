<?php
if($_SERVER['REQUEST_METHOD'] === "POST"){
  if (empty($_POST['username']) || empty($_POST['password']) ) {
    $message = '<p>Something went wrong. You must fill all the fields</p>';
  } else {
    $username = ECVChat\sanitizeString($_POST['username']);
    $password = ECVChat\sanitizeString($_POST['password']);

    try {
      $user = ECVChat\DB\login($username, $password);

      $_SESSION['id'] = $user["id"];
      $_SESSION['username'] = $user["username"];
      if($user["photo_id"]){
        $_SESSION['photo_id'] = $user["photo_id"];
      }

      ECVChat\redirect("index.php");
    } catch (Exception $e) {
      $message = '<p>' . $e->getMessage() . '</p>';
    }
  }
}
?>
<div>
  <form method="post" action="">
    <fieldset>
      <legend>Connexion</legend>
      <p>
        <label>Username :</label>
        <input name="username" type="text" /><br />

        <label>Password :</label>
        <input name="password" type="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Login" />
    </p>
  </form>
  <div class="error"><?php echo isset($message) ? $message : "";?></div>
  <a href="signin.php">Sign in!</a>
</div>