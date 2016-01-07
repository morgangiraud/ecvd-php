<?php require_once('requires/header.php');


  if(isset($_POST['username'])) {
    require_once('requires/functions.php');
    \ECVChat\insertUser();
  }
?>

<div>
  <form method="post" action="signin.php">

    <fieldset>

      <legend>Register</legend>

      <p>
        <label>Username :</label>
        <input type="text" name="username" /><br />

        <label>Email :</label>
        <input type="email" name="email" />

        <label>Password :</label>
        <input type="password" name="password" />
      </p>

    </fieldset>

    <p>
      <input type="submit" value="Register" />
    </p>

  </form>

  <div class="error"></div>
</div>

<?php require_once('requires/footer.php');