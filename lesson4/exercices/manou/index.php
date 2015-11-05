<?php
session_start();
session_regenerate_id();

$host= "127.0.0.1";
$dbname= "ecvdphp";
$user= "manou";
$pass= "root";

try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  }catch (PDOException $e){
    echo $e->getMessage();
}

$message = "";
if(isset($_SESSION['id'])){
  echo "<p>{$_SESSION['username']}: you are logged in!</p>";
  echo '<a href="logout.php">Logout</a>';
  exit();
} else if($_SERVER['REQUEST_METHOD'] === "POST"){
  if (empty($_POST['pseudo']) || empty($_POST['password']) ) {
    $message = '<p>Something went wrong. You must fill all the fields</p>';
  } else {
    $pseudo = trim($_POST['pseudo']); // To improve the ux of the user, you can trim the input
    $password = trim($_POST['password']);

    $filename = 'users.txt';
    if(file_exists($filename)){
      // PHP memory limit are set as a string like '512K' or '12M'
      // but filesize returns the file size in octet
      // which mean we have to calculate the memory limit in octet
      $memoryLimit = ini_get('memory_limit');
      if (preg_match('/^(\d+)(.)$/', $memoryLimit, $matches)) { 
          if ($matches[2] == 'M') {
              $memoryLimit = $matches[1] * 1024 * 1024;
          } else if ($matches[2] == 'K') {
              $memoryLimit = $matches[1] * 1024;
          } else {
            $memoryLimit;
          }
      }
      $filesize = filesize($filename);
      if($filesize < $memoryLimit / 2){
        $content = file_get_contents($filename);

        $content = explode(PHP_EOL, $content);
        foreach ($content as $line) {
          $credentials = str_getcsv($line);
          if(count($credentials) !== 3){
            continue;
          }
          if($pseudo === $credentials[0] && password_verify($password, $credentials[2])){
            $_SESSION['id'] = $credentials[0];
            $_SESSION['username'] = $credentials[1];
            header('Location: ' . $_SERVER['PHP_SELF'], true, 301);
            exit();
          }
        }
      } else {
        $file = fopen($filename, 'r');
        
        while (($credentials = fgetcsv($file)) !== false) {
            if($pseudo === $credentials[0] && password_verify($password, $credentials[2])){
              fclose($file);

              $_SESSION['id'] = $credentials[0];
              $_SESSION['username'] = $credentials[1];
              header('Location: ' . $_SERVER['PHP_SELF'], true, 301);
              exit();
            }
        }
        fclose($file);
      }
      $message = '<p>Something went wrong. Username or password is wrong</p>';
    } else {
      $message = '<p>Something went wrong. Username or password is wrong</p>';
    }          
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