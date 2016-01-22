<div id="<?php echo "post-" . $post['id'];?>" class="post">
    <p>
        <?php echo $post['title']; ?>      
    </p>
    <p>
        <?php echo $post['body']; ?>      
    </p>
    <small>
        Created by <?php echo $post['username']; ?> at  <?php echo $post['created_at']; ?>
    </small>
    <br>
    <small>
        <a href="post/edit.php?id=<?php echo $post['id']; ?>">Edit</a>
        <a href="post/show.php?id=<?php echo $post['id']; ?>">Show</a>
    </small>
</div>