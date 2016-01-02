<?php require_once('requires/header.php');

  if(isset($_POST['username'])) {
    require_once('requires/functions.php');
    \ECVChat\login();
  }
?>
<div>
  <form method="post" action="login.php">
    <fieldset>
      <legend>Connexion</legend>
      <p>
        <label>Username :</label>
        <input type="text" name="username" /><br />

        <label>Password :</label>
        <input type="password" name="password" />
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Login" />
    </p>
  </form>
  <div class="error"></div>
  <a href="signin.php">Sign in!</a>
</div>

<?php require_once('requires/footer.php');