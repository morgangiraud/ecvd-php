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
<div id="<?php echo "post-" . $post['id'];?>" class="post">
    <p>
        <?php echo $post['title']; ?>      
    </p>
    <p>
        <?php echo $post['body']; ?>      
    </p>
    <?php 
    if(isset($post['filename'])) {
        echo "<img width='400px' src='" . $post['path'] . "/" . $post['filename'] . "." . $post['extension'] . "'>";
    }
    ?>
  </div>
<?php
ecvdphp\render('../footer.php', [
    'prefix' => "../"
]);
?>