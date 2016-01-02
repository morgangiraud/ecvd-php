<?php
require_once 'session.php';
require_once 'pdo.php';
require_once 'functions.php';

$message = "";
if(!isset($_SESSION['id'])){
  ECVChat\redirect('index.php');
} else if($_SERVER['REQUEST_METHOD'] === "POST"){
  if (ECVChat\checkUpload("filedata")) {
    try {
      $urlExploded = explode("/", $_SERVER["REQUEST_URI"]);
      array_pop($urlExploded);
      $path = implode("/", $urlExploded) . "/uploads";

      list($filename, $extension) = ECVChat\uploadFile($_FILES['filedata']['name']);

      ECVChat\DB\updateUserImage($_SESSION['id'], $path, $filename, $extension);

      $_SESSION['photo_url'] = $path . "/" . $filename . "." . $extension;
    } catch (Exception $e) {
      $message = '<p>' . $e->getMessage() . '</p>';    
    }
  } else {
    $message = '<p>Something went wrong. You must fill all the fields</p>';  
  }
}

require_once 'header.php';
?>
<div>
  <form enctype="multipart/form-data" action="" method="post">
    <fieldset>
      <legend>Your personal information</legend>
      <p>
        <img width=120 src="<?php echo isset($_SESSION['photo_url']) ? $_SESSION['photo_url'] : "";?>"><br>
        <label for="filedata">Picture :</label>
        <input name="filedata" type="file" />

        <input type="submit" value="Send file" />
      </p>
    </fieldset>
  </form>
  <div class="error"><?php echo isset($message) ? $message : "";?></div>
  <a href="index.php">Go to the chat!</a>
</div>
<?php
require_once 'footer.php'
?>