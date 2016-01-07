<?php
require_once '../session.php';
require_once '../functions.php';
require_once '../connect.php';

if(!isset($_SESSION['id'])){ // The user must be logged in
  ecvdphp\redirect('../index.php');
}

if(!isset($_GET['id']) && $_GET['id'] != ''){ // The user must be logged in
  ecvdphp\redirect('../index.php');
}
$postId = intval($_GET['id']);
$post = ecvdphp\DB\Post\getPostById($postId);

include '../header.php';
?>
  <div>
    <form enctype="multipart/form-data" method="post" action="">
      <fieldset>
        <legend>New post</legend>
        <p>
          <label for="title">Title :</label>
          <input name="title" type="text" id="title" value=""/>
          <br />
          <label for="body">Content :</label>
          <textarea name="body" id="body" ></textarea>
          <br />
          <label for="filedata">Picture :</label>
          <input name="filedata" type="file" />
          <br>
          <label for="file-url">Picture URL :</label>
          <input name="file-url" size="64" type="text" />
          <input type="submit" value="Send file" />
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Update" />
      </p>
    </form>
  </div>
<?php
include '../footer.php';
?>