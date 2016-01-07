<?php 
  require 'functions.php';
?>

<div>
  <form method="post" action="">
    <fieldset>
      <legend>Register</legend>
      <p>
        <label>Username :</label>
        <input name="name" type="text"/><br />

        <label>Email :</label>
        <input name="mail" type="email"/>

        <label>Password :</label>
        <input name="pwd" type="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Register" />
    </p>
  </form>
  <div class="error"></div>
</div>

<?php
  if(isset($_POST['name']) && empty($_POST['name']) == false && 
    empty($_POST['pwd']) == false && isset($_POST['pwd']) && 
    empty($_POST['mail']) == false && isset($_POST['mail'])) {

    $name = ECVChat\sanitizeString($_POST['name']);
    $mail = ECVChat\sanitizeString($_POST['mail']);
    $pwd = ECVChat\sanitizeString($_POST['pwd']);

    ECVChat\DB\register($name,$pwd,$mail);

  }
?>