<?php
  require 'functions.php';
?>
<div>
  <form enctype="multipart/form-data"  method="post">
    <fieldset>
      <legend>Your personal information</legend>
      <p>
        <img width=120 src=""><br>
        <label for="filedata">Picture :</label>
        <input name="file" type="file" />
        <br>
        <label for="file-url">Picture URL :</label>
        <input name="fileUrl" size="64" type="text" />

        <input type="submit" value="Send file" />
      </p>
    </fieldset>
  </form>
  <div class="error"></div>
  <a href="logout.php">Log out!</a>
  <a href="chat.php">Go to the chat!</a>
</div>

<?php
  if(isset($_POST["file"])){
      if(ECVChat\checkUpload($_FILES["file"])){
        $info = ECVChat\uploadFile($_FILES["file"]);
        echo $info;
      }
  }else if(isset($_POST["fileUrl"])){
      if(ECVChat\checkUpload($_FILES["fileUrl"])){
        $info = ECVChat\uploadFile($_FILES["fileUrl"]);
        echo $info;
      }
  }else{
    echo 'nothing';
  }
?>