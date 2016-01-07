<?php

require('session.php');
require('connect.php');
require('header.php'); 
require('functions.php'); 


//if( !$_SESSION["logged"] ) {
//    redirect('index.php');
//}


if( $_POST['postname'] ) {
    $query = $conn->prepare("INSERT INTO posts VALUES (null, :title, :user_id, :image_id, null, :content)");
    

    $query->bindParam(':title', $_POST["postname"], PDO::PARAM_STR);
    $query->bindParam(':user_id', $_SESSION["userId"], PDO::PARAM_STR);
    $query->bindParam(':image_id', 3, PDO::PARAM_STR);
//    $query->bindParam(':created_at', null, PDO::PARAM_STR);
    $query->bindParam(':content', $_POST["postcontent"], PDO::PARAM_STR);

    $query->execute();

//    redirect('blog.php');
} ?>


    <h1>Create post</h1>


    <form action="create-post.php" method="post">
        <label for="postname">Post title : </label>
        <input type="text" name="postname" id="postname">
        <br>
        <br>
        <label for="postcontent">Post content : </label>
        <br>

        <textarea name="postcontent" id="postcontent" cols="30" rows="10"></textarea>
        <br>
        <input type="file">
        <br>
        <input type="submit" value="Post">
    </form>

    <a href="index.php">Home</a>