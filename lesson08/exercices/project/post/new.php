<?php
require_once '../session.php';
require_once '../functions.php';
require_once '../connect.php';

if(!isset($_SESSION['id'])){ // The user must be logged in
  ecvdphp\redirect('../index.php');
}

if($_SERVER['REQUEST_METHOD'] === "POST"){
  $title = ($_POST['title'] != null) ? trim($_POST['title']) : "";
  $body = ($_POST['body'] != null) ? trim($_POST['body']) : "";
  $imageData = null;

  $urlExploded = explode("/", $_SERVER["REQUEST_URI"]);
  array_pop($urlExploded);
  $path = implode("/", $urlExploded) . "/uploads";
  if(ecvdphp\checkUploadedFile('filedata')){
    if(!preg_match('/jpeg|jpg|png/', $_FILES['filedata']['type'])){
      ecvdphp\addFlashMessage('error', 'You can only upload jpeg or png files');
    } else {
      list($filename, $extension) = ecvdphp\saveUploadedImage($_FILES['filedata']['name']);
      $imageData = array(
        'filename' => $filename,
        'path' => $path,
        'extension' => $extension,
      );
    }
  } else if(isset($_POST['file-url']) && !empty($_POST['file-url']) && !!filter_var($_POST['file-url'], FILTER_VALIDATE_URL)){
    $fileUrl = $_POST['file-url'];
    
    list($filename, $extension) = ecvdphp\downloadImageFromUrl($fileUrl);
    $imageData = array(
      'filename' => $filename,
      'path' => $path,
      'extension' => $extension,
    );
  } else {
    ecvdphp\addFlashMessage('error', 'The uploaded file couldn\'t be found');
  }

  try {
    $postId = ecvdphp\DB\Post\insertNewPost($_SESSION['id'], $title, $body, $imageData);
    ecvdphp\addFlashMessage('success', 'You\'ve successfully created a new post');
    ecvdphp\redirect('show.php?id=' . $postId);
  } catch (Exception $e) {
    ecvdphp\addFlashMessage('error', $e->getMessage());
  }

}

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