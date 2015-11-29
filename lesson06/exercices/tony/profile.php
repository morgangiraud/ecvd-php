<?php



require('session.php');
require('connect.php');

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


//print_r($_FILES[]);


//if(isset($_FILES)) {
//    $uploadsDir = 'upload/';
//    $file = basename($_FILES['file']['name']);
//    if(move_uploaded_file($_FILES['file']['tmp_name'], $folder . $file)) {
//      echo 'Upload';
//    } else {
//      echo 'Echec';
//    }
//}

$uploadsDir = 'upload/';
$fileName = basename($_FILES['userfile']['name']);

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadsDir . $fileName)) {    
    $query = $conn->prepare("INSERT INTO files VALUES (null, :filename, :path, :extension)");
    
    $query->bindParam(':filename', $fileName, PDO::PARAM_STR);
    $query->bindParam(':path', $uploadsDir, PDO::PARAM_STR);
    $query->bindParam(':extension', $_FILES['userfile']['type'], PDO::PARAM_STR);
    
    $query->execute(); 
    echo "Photo de profil mise à jour !";
    
 
    $query = $conn->prepare("UPDATE users SET image_id= :id WHERE username = :username");
    $query->bindParam(':id', $conn->lastInsertId(), PDO::PARAM_STR);
    $query->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $query->execute();
    
    
} else {
    echo "Erreur lors du chargmenet du fichier.";
}

//if( $_POST ) { 
//    $username = $_POST["username"];
//    $email = $_POST["email"];
//    $password = $_POST["password"];
//    
//    
//    
//    $stmt = $conn->prepare('UPDATE users SET username = :username, email = :email, password = :password WHERE username = :currentUsername');
//
//    
//    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
//    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
//    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
//    $stmt->bindParam(':currentUsername', $_SESSION['username'], PDO::PARAM_STR);
//
//    $stmt->execute();
//    
//    
//
//    $_SESSION["username"] = $username;
//    $_SESSION["email"] = $email;
//    
//    
//    header('Location: profile.php');
//    exit;
//   
//}