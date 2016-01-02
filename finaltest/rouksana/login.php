<?php 
  require_once 'session.php';
  require_once 'functions.php';

  $error = "";

  if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(empty($_POST['username']) || empty($_POST['password']) ){
      $error = '<p>Please fill all the fields</p>';
    }else{
      $username = ECVChat\sanitizeString($_POST['username']);
      $password = ECVChat\sanitizeString($_POST['password']);

      $user = ECVChat\DB\login($username, $password);

      if($user){
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['photo_id'] = $user['photo_id'];
        ECVChat\redirect('chat.php');
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
      <legend>Connexion</legend>
      <p>
        <label for="username">Username :</label>
        <input name="username" type="text" /><br />

        <label for="password">Password :</label>
        <input name="password" type="password"/>
      </p>
    </fieldset>
    <p>
      <input type="submit" value="Login" />
    </p>
  </form>
  <div class="error">
    <?php if(isset($error)){ echo $error; } ?>
  </div>
  <a href="signin.php">Sign in!</a>
</div>

<?php include 'footer.php';?>