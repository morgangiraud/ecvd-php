<div id="ecvchat">
  <header class="clearfix">
    <a href="#" class="ecvchat-close">x</a>
    <h4><?php echo $_SESSION['username']; ?></h4>
    <span class="ecvchat-message-counter">3</span>
  </header>
  <div class="ecvchat">
    <div class="ecvchat-history">
      <?php
        foreach ($messages as $key => $message) {
          $time = new DateTime($message['created_at']);
          $formattedTime = $time->format('H:i');
          if(isset($message["path"])){
            $photoUrl = $message['path'] . "/" . $message['filename'] . "." . $message['extension'];
          } else {
            $photoUrl = null;
          }
          ECVChat\render('message.php', array(
            'photoUrl' => $photoUrl,
            'time' => $formattedTime,
            'username' => $message['username'],
            'message' => $message['message']
          ));
        }
      ?>
    </div>
    <form method="post" action="">
      <fieldset>
        <input name="message" type="text" placeholder="Type your message…" autofocus>
        <input type="hidden">
      </fieldset>
    </form>
  </div>
  <div class="error"></div>
</div>
<a href="profile.php">Profile</a><br>