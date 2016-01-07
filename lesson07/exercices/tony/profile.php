<?php


require('session.php');
require('connect.php');
require('functions.php');

function urlExists($url){
   $headers = get_headers($url);
   return stripos($headers[0], "200 OK") ? true : false;
}


function setProfilePicture($fileName) {
    global $conn;
    $fileType = end(explode('.', $fileName));
    $uploadsDir = 'upload/';
    try {
        var_dump($conn);
        $conn->beginTransaction();
        
        $query = $conn->prepare("INSERT INTO files VALUES (null, :filename, :path, :extension)");
        $query->bindParam(':filename', $fileName, PDO::PARAM_STR);
        $query->bindParam(':path', $uploadsDir, PDO::PARAM_STR);
        $query->bindParam(':extension', $fileType, PDO::PARAM_STR);
        $query->execute();
        

        $query = $conn->prepare("UPDATE users SET image_id= :id WHERE username = :username");
        $query->bindParam(':id', $conn->lastInsertId(), PDO::PARAM_STR);
        $query->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
        $query->execute();

        $conn->commit();

    } catch (Exception $e) {
        $conn->rollBack();
        echo "Failed: " . $e->getMessage();
    }
}

if( !$_SESSION["logged"] ) {
    redirect('index.php');
}

if($_FILES['userfile'] || $_POST['urlimage']) {    
        
    $uploadsDir = 'upload/';
    $fileName = basename($_FILES['userfile']['name']);
    
    if($_POST['urlimage'] && urlExists($_POST['urlimage'])) {
        $fileName = end(explode('/', $_POST['urlimage']));
        $source = $_POST['urlimage'];
        file_put_contents($uploadsDir . $fileName, file_get_contents($source));
        setProfilePicture($fileName);
    };
    
    
    $source = $_FILES['userfile']['tmp_name'];
    
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadsDir . $fileName)) {    
        setProfilePicture($fileName);
    }
}



if( $_SESSION["logged"] ) {

    require('header.php');
    
    $query = $conn->prepare("SELECT path, filename FROM files, users WHERE users.username = :username AND users.image_id = files.id");
    $query->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $result = $query->execute();
    $result = $query->fetchAll();
    $userImage = $result[0];
    
    ?>

    <h1>Hello <?= ucfirst($_SESSION["username"]) ?></h1>

    <hr>

    <form action="" method="post" enctype="multipart/form-data">

        <input type="text" placeholder="Username" name="username" value="<?= $_SESSION['username'] ?>">
        <br>
        <input type="text" placeholder="Email" name="email" value="<?= $_SESSION['email'] ?>">
        <br>
        <input type="password" placeholder="Password" name="password">
        <br>
        <br>
        <img src="<?= $userImage['path'] . $userImage['filename']?> " style="max-width:180px;">
        <br>
        <label for="userfile">Photo de profil</label>
        <br>
        <input type="file" name="userfile" id="userfile">
        <br>
        <label for="urlimage">URL image</label>
        <br><input type="text" name="urlimage" id="urlimage">
        <br>
        <br>
        <input type="submit" value="Update profile">

    </form>
    <br>
    <a href="index.php">Home</a>

    <?php
        
    require('footer.php');

} else {
    
    header('Location: index.php');
    exit;
    
}

