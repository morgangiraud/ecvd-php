<?php
	$msgs = ECVChat\DB\getLastMessage();

?>

<div class="ecvchat-message clearfix">
  <img src="http://lorempixum.com/32/32/people" alt="" width="32" height="32">
  <?php
  	foreach ($msgs as $value) {
  		$user =  ECVChat\DB\getUser($value['user_id']);
  		echo $value['user_id'];
  	?>
  		<div class="ecvchat-message-content clearfix">
		    <span class="ecvchat-time"><?php echo $value["created_at"] ?></span>
		    <h5><?php echo $user ?></h5>
		    <p><?php echo $value["message"] ?></p>
		</div>
	<?php
  	}
  ?>
</div>
<hr>