<?php 
  require_once('functions.php');

  $error = "";

  if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) ){
      $error = '<p>Please fill all the fields</p>';
    }else{
      $username = ECVChat\sanitizeString($_POST['username']);
      $email = ECVChat\sanitizeString($_POST['email']);
      $password = ECVChat\sanitizeString($_POST['password']);
      $id = ECVChat\DB\register($username, $password, $email);

      if($id){
        ECVChat\redirect('login.php');
      }else{
        $error = '<p>Something went wrong...</p>';
      }
    } 
  }

  include 'header.php';
?>

<div>
  <form method="post" action="">
    <fieldset>
      <legend>Register</legend>
      <p>
        <label for="username">Username :</label>
        <input name="username" type="text"/><br />

        <label for="email">Email :</label>
        <input name="email" type="email"/><br />

        <label for="password">Password :</label>
        <input name="password" type="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Register" />
    </p>
  </form>
  <div class="error">
    <?php if(isset($error)){ echo $error; } ?>
  </div>
</div>

<?php include 'footer.php';?>