<?php 
require('session.php');
require('pdo.php');
?>

<div>
  <form method="post" action="">
    <fieldset>
      <legend>Register</legend>
      <p>
        <label>Username :</label>
        <input type="text" name="name"/><br />

        <label>Email :</label>
        <input type="email" name="email"/>

        <label>Password :</label>
        <input type="password" name="pwd"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Register" />
    </p>
  </form>
  <div class="error"></div>
</div>

<?php


  try {

    $result = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
      $result->bindParam(':email', $_POST['email'], PDO::PARAM_INT);
      $result->bindParam(':username', $_POST['name'], PDO::PARAM_INT);
      $result->bindParam(':password', $_POST['pwd'], PDO::PARAM_INT);
      $result->execute();
        $result->fetchAll();
  }
  catch (PDOException $e) {

    echo 'Échec lors de la connexion : ' . $e->getMessage();

  }
?>