<div class="ecvchat-message clearfix">
  <?php
    if(isset($photoUrl)){
      echo '<img src="' . $photoUrl . '" alt="" width="32" height="32">';
    } else {
      echo '<img src="http://lorempixum.com/32/32/people" alt="" width="32" height="32">';
    }
  ?>
  <div class="ecvchat-message-content clearfix">
    <span class="ecvchat-time"><?php echo $time; ?></span>
    <h5><?php echo $username; ?></h5>
    <p><?php echo $message; ?></p>
  </div>
</div>
<hr>