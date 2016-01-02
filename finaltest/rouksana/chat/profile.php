<?php
  require_once 'session.php';
  require_once 'functions.php'; 

  $error = "";
  if(ECVChat\checkUpload('filedata')){
    list($name, $extension) = ECVChat\uploadFile($_FILES['filedata']['name']);

    $path = 'uploads/';
    $imageId = ECVChat\DB\updateUserImage($_SESSION['id'], $name, $path, $extension);
    $_SESSION['photo_id'] = $imageId;
    $_SESSION['photo_url'] = $path . $name . "." . $extension;

  }else{
    $error = "The uploaded file isn't found.";
  }

  include 'header.php';
?>
<div>
  <form enctype="multipart/form-data" action="" method="post">
    <fieldset>
      <legend>Your personal information</legend>
      <p>
        <?php 
            if($_SESSION['photo_id'] != null){
              echo '<img width=120 src="' . $_SESSION['photo_url'] . '"><br>';
            }
          ?>
        <label for="filedata">Picture :</label>
        <input name="filedata" type="file" />

        <input type="submit" value="Send file" />
      </p>
    </fieldset>
  </form>
  <div class="error">
    <?php if(isset($error)){ echo $error; } ?>
  </div>
  <a href="logout.php">Log out!</a>
  <a href="chat.php">Go to the chat!</a>
</div>

<?php include 'footer.php';?>