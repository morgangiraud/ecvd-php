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

if(!isset($_SESSION['id'])){ // The user must be logged in
  header('Location:login.php', true, 301);
  exit;
}

$message = "";
if($_SERVER['REQUEST_METHOD'] === "POST"){
  $newUsername = $_POST['username'];
  $newEmail = ($_POST['email'] != null) ? $_POST['email'] : "";
  $newPassword = ($_POST['password'] != null) ? $_POST['password'] : "";
  $newDescription = $_POST['description'];

  if($newPassword != ""){
    $query = "UPDATE users SET 
    password='" . password_hash($newPassword, PASSWORD_BCRYPT) . "',
    description='" . $newDescription . "'
    WHERE id=" . $_SESSION['id'];
  } else {
    $query = "UPDATE users SET 
    username='" . $newUsername  . "', 
    email='" . $newEmail . "',
    description='" . $newDescription . "'
    WHERE id=" . $_SESSION['id'];
  }
  $conn->exec($query);
}

$result = $conn->query("SELECT id, username, email, description FROM users WHERE id=" . $_SESSION['id'])->fetchAll();
$user = $result[0]; 


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
        <legend>Your profile</legend>
        <p>
          <label for="username">Username :</label>
          <input name="username" type="text" id="username" value="<?php echo $user['username']; ?>"/>
          <br />
          <label for="email">Email :</label>
          <input name="email" type="text" id="email" value="<?php echo $user['email']; ?>"/>
          <br />
          <label for="password">Password :</label>
          <input name="password" type="password" id="password"/>
          <br />
          <label for="description">Description:</label>
          <textarea name="description" id="description" rows="10" cols="50"><?php echo $user['description']; ?></textarea>
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Update" />
      </p>
    </form>
    <div class="error"><?php echo $message; ?></div>
    <a href="delete.php">Delete your account now!</a>
  </div>
</body>
</html>