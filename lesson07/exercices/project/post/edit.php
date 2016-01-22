<?php
require_once '../session.php';
require_once '../functions.php';
require_once '../connect.php';

if(!isset($_SESSION['id']) || !isset($_GET['id'])){ // The user must be logged in
  ecvdphp\redirect('../index.php');
}

$postId = intval($_GET['id']);
$post = ecvdphp\DB\Post\getPostById($postId);

if(empty($post)){
    ecvdphp\redirect('../index.php');
};

ecvdphp\render('../header.php', [
    'prefix' => "../"
]);
?>
  <div>
    <form enctype="multipart/form-data" method="post" action="">
      <fieldset>
        <legend>New post</legend>
        <p>
          <label for="title">Title :</label>
          <input name="title" type="text" id="title" value="<?php echo $post['title']; ?>"/>
          <br />
          <label for="body">Content :</label>
          <textarea name="body" id="body"><?php echo $post['body']; ?></textarea>
          <br />
          <label for="filedata">Picture :</label>
          <input name="filedata" type="file" />
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Update" />
      </p>
    </form>
  </div>
<?php
ecvdphp\render('../footer.php', [
    'prefix' => "../"
]);
?>