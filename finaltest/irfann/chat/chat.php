<?php
  require 'functions.php';
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
      <?php 
        include 'message.php';
      ?>
    </div>
    <form method="post">
      <fieldset>
        <input type="text" name="msg" placeholder="Type your message…" autofocus>
        <input type="hidden">
      </fieldset>
    </form>
  </div>
</div>
<div class="error"></div>
<a href="logout.php">Log out!</a>
<a href="profile.php">Profile</a>

<?php 
  if(isset($_POST['msg'])){
    ECVChat\DB\addMessage($_POST['msg']);
  }
?>