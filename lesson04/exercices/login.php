<?php
session_start();
session_regenerate_id();

try{
  $host = "127.0.0.1"; // Use an IP Adresse
  $dbName = "ecvdphp";
  $dbUsername = "ecvduser";
  $dbPassword = "ecvd";

  $conn = new PDO("mysql:host=$host;dbname=$dbName", $dbUsername, $dbPassword);
  $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Activate exception
} catch (\PDOException $e){
  echo $e->getMessage();
  exit;
}

$message = "";
if(isset($_SESSION['id'])){
  echo "<p>{$_SESSION['username']}: you are logged in!</p>";
?>
<a href="profile.php">My profile</a>
<br>
<a href="logout.php">Logout</a>
<?php
  exit();
} else if($_SERVER['REQUEST_METHOD'] === "POST"){
  if (empty($_POST['pseudo']) || empty($_POST['password']) ) {
    $message = '<p>Something went wrong. You must fill all the fields</p>';
  } else {
    $pseudo = trim($_POST['pseudo']); // To improve the ux of the user, you can trim the input
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if($stmt->execute(array($pseudo))){
      $result = $stmt->fetchAll();      
      if(count($result) === 1 && password_verify($password, $result[0]['password'])) {
        $_SESSION['id'] = $result[0]["id"];
        $_SESSION['username'] = $result[0]["username"];
        header('Location: ' . $_SERVER['PHP_SELF'], true, 301);
        exit();
      }
    }
    $message = '<p>Something went wrong. Username or password is wrong</p>';
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <div>
    
    <form method="post" action="">
      <fieldset>
        <legend>Connexion</legend>
        <p>
          <label for="pseudo">Pseudo :</label>
          <input name="pseudo" type="text" id="pseudo" /><br />

          <label for="password">Mot de Passe :</label>
          <input type="password" name="password" id="password" />
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Login" />
      </p>
    </form>
    <div class="error"><?php echo $message; ?></div>
    <a href="signin.php">Sign in!</a>
  </div>
</body>
</html>