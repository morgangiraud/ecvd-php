<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

if(!isset($_SESSION['id'])){ // The user must be logged in
  redirect('login.php');
}

$message = "";
if($_SERVER['REQUEST_METHOD'] === "POST"){
  $newUsername = ($_POST['username'] != null) ? trim($_POST['username']) : "";
  $newEmail = ($_POST['email'] != null) ? trim($_POST['email']) : "";
  $newPassword = ($_POST['password'] != null) ? trim($_POST['password']) : "";
  $newDescription = trim($_POST['description']);

  if($newPassword != ""){
    $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id=:id");
    $stmt->bindParam(':password', password_hash($newPassword, PASSWORD_BCRYPT));
    $stmt->bindParam(':id', $_SESSION['id']);
  } else {
    $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, description = :description WHERE id=:id");
    $stmt->bindParam(':username', $newUsername);
    $stmt->bindParam(':email', $newEmail);
    $stmt->bindParam(':description', $newDescription);
    $stmt->bindParam(':id', $_SESSION['id']);
  }
  if(!$stmt->execute()){

  }
}

$result = $conn->query("SELECT id, username, email, description FROM users WHERE id=" . $_SESSION['id'])->fetchAll();
$user = $result[0]; 

include 'header.php';
?>
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
    <a href="delete.php">Delete your account now!</a>
  </div>
<?php
include 'footer.php';
?>