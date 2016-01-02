<?php



require_once('session.php');
require_once('pdo.php');
require_once('functions.php');

if( $_POST ):  
  login($_POST["username"], $_POST["password"]);

else :
  require('header.php');
  
  ?>
   
  <form method="post" action="">
    <fieldset>
      <legend>Connexion</legend>
      <p>
        <label>Username :</label>
        <input type="text" name="username" id="username"/><br />

        <label>Password :</label>
        <input type="password" name="password" id="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Login" />
    </p>
  </form>
  <div class="error"></div>
  <a href="signup.php">Sign up!</a>

<?php

  require('footer.php');
endif;








