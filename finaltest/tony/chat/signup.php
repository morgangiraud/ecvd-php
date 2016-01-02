<?php



require_once('session.php');
require_once('pdo.php');
require_once('functions.php');

if( $_POST ):
  
  
  register($_POST["username"], $_POST["password"], $_POST["email"]);

else :
  require('header.php');
  
  ?>
   
  <form method="post" action="">
    <fieldset>
      <legend>Register</legend>
      <p>
        <label>Username :</label>
        <input type="text" name="username" id="username"/><br />

        <label>Email :</label>
        <input type="email" name="email" id="email"/>

        <label>Password :</label>
        <input type="password" name="password" id="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Register" />
    </p>
  </form>
  <div class="error"></div>

  <br>
  <a href="login.php">Connexion</a>

<?php

  require('footer.php');
endif;








