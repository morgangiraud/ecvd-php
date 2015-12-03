<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

if(!isset($_SESSION['id'])){ // The user must be logged in
  ecvdphp\redirect('login.php');
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

$query = "SELECT * FROM users 
  LEFT JOIN files on users.image_id = files.id
  WHERE users.id=" . $_SESSION['id'];
$result = $conn->query($query)->fetchAll();
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
    <form enctype="multipart/form-data" action="upload.php" method="post">
      <fieldset>
        <legend>Your personal information</legend>
        <p>
          <?php 
            if($user['image_id'] != null){
              echo '<img width=240 src="' . $user['path'] . "/" . $user['filename'] . "." . $user['extension'] . '"><br>';
            }
          ?>
          <label for="filedata">Picture :</label>
          <input name="filedata" type="file" />
          <br>
          <label for="file-url">Picture URL :</label>
          <input name="file-url" size="64" type="text" />
          <input type="submit" value="Send file" />
        </p>
      </fieldset>
    </form>
    <a href="delete.php">Delete your account now!</a>
  </div>
<?php
include 'footer.php';
?>