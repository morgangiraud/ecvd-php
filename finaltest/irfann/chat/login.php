<?php
  require 'functions.php';
?>
<div>
  <form method="post" action="">
    <fieldset>
      <legend>Connexion</legend>
      <p>
        <label>Username :</label>
        <input name="name" type="text" /><br />

        <label>Password :</label>
        <input name="pwd" type="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Login" />
    </p>
  </form>
  <div class="error"></div>
  <a href="signin.php">Sign up!</a>
</div>

<?php
  if(isset($_POST['name']) && empty($_POST['name']) == false && 
    empty($_POST['pwd']) == false && isset($_POST['pwd'])) {

    $name = ECVChat\sanitizeString($_POST['name']);
    $pwd = ECVChat\sanitizeString($_POST['pwd']);

    ECVChat\DB\login($name,$pwd);

  }
?>