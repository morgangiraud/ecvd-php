<?php 
  require_once 'session.php';
  require_once 'functions.php';

  $error = "";

  if($_SERVER['REQUEST_METHOD'] === "POST"){
    ECVChat\DB\addMessage($_SESSION['id'], $_POST['message']);
  }else{
    $error = '<p>Something went wrong...</p>';
  }

  $datas = ECVChat\DB\getLastMessage();

  include 'header.php'; 
?>
<div id="ecvchat">
  <header class="clearfix">
    <a href="#" class="ecvchat-close">x</a>
    <h4><?php echo $_SESSION['username']; ?></h4>
    <span class="ecvchat-message-counter">3</span>
  </header>
  <div class="ecvchat">
    <div class="ecvchat-history">

    <?php 
      foreach ($datas as $data):
        $img = $data['path'] . $data['filename'] . '.' .$data['extension'];
        list($date, $time) = explode(' ', $data['created_at']);
    ?>

      <div class="ecvchat-message clearfix">
        <img src="<?php echo $img; ?>" alt="" width="32" height="32">
        <div class="ecvchat-message-content clearfix">
          <span class="ecvchat-time"><?php echo $time; ?></span>
          <h5><?php echo $data['username']; ?></h5>
          <p><?php echo $data['message']; ?></p>
        </div>
      </div>
      <hr>

    <?php endforeach; ?>

    </div>
    <form method="post" action="">
      <fieldset>
        <input type="text" name="message" placeholder="Type your message…" autofocus>
        <input type="hidden">
      </fieldset>
    </form>
  </div>
</div>
<div class="error">
    <?php if(isset($error)){ echo $error; } ?>
</div>
<a href="logout.php">Log out!</a>
<a href="profile.php">Profile</a>

<?php include 'footer.php'; ?>