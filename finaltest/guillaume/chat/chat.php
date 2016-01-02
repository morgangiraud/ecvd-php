<?php require_once('requires/header.php');
require_once('requires/functions.php');

if(isset($_POST['message'])) \ECVChat\DB\addMessage($_POST['message']);

$messages = \ECVChat\DB\getLastMessage();

?>

<div id="ecvchat">

  <header class="clearfix">
    <a href="#" class="ecvchat-close">x</a>
    <h4>John Doe</h4>
    <span class="ecvchat-message-counter">3</span>
  </header>

  <div class="ecvchat">
    <div class="ecvchat-history">
      <!-- Chat messages here -->

      <?php foreach ($messages as $message) { ?>

        <div class="ecvchat-message clearfix">
          <img src="<?php echo $message['path'].$message['filename'] ?>" alt="" width="32" height="32">
          <div class="ecvchat-message-content clearfix">
            <span class="ecvchat-time"><?=$message['created_at']?></span>
            <h5><?=$message['username']?></h5>
            <p><?=$message['message']?></p>
          </div>
        </div>
        <hr>

      <?php } ?>

    </div>
    <form method="post" action="chat.php">
      <fieldset>
        <input type="text" name="message" placeholder="Type your message…" autofocus>
        <input type="hidden">
      </fieldset>
    </form>

  </div>

</div>

<div class="error"></div>
<a href="requires/logout.php">Log out!</a>
<a href="profile.php">Profile</a>

<?php require_once('requires/footer.php') ?>