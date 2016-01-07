<!DOCTYPE hmtl>
<html>
<head>
<title></title>
</head>
<body>
<?php
if (!isset($_GET['Username'])){
  $email = null;
} else if(!is_string($_GET['username'])){
  $email = false;
} else {
  $email = $_GET['username'];
}
$password = isset($_GET['password']) && is_string($_GET['password'])? $_GET['password'] : '';
$password = isset($_GET['email']) && is_string($_GET['email'])? $_GET['email'] : '';
?>
?>
<div>
  <form method="post" action="">
    <fieldset>
      <legend>Register</legend>
      <p>
        <label>Username :</label>
        <input type="text"/><br />

        <label>Email :</label>
        <input type="email"/>

        <label>Password :</label>
        <input type="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Register" />
    </p>
  </form>
  <div class="error"></div>
</div>
</body>
</html>