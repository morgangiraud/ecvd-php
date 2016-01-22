<p>Welcome <?php echo $user['username']; ?>!</p>
<?php
if(count($posts)){
    foreach ($posts as $key => $post) {
        ecvdphp\render("post/list.php", array(
            'post' => $post,
        ));
    }
} else {
    echo '<p>You don\'t have any post yet, <a href="post/new.php">Create one!</a></p>';
}
?>
