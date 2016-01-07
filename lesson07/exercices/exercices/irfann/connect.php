<?php 
    require("session.php");
    require("init.php");
    require("function.php");
    require("header.php");
    
    $pwd = hash('haval256,5', trim($_SESSION['pwd_user']));
    $user = fullUser($_SESSION['login_user'],$pwd);

    

?>

    <h1>CONNECT to <?php echo $_SESSION['login_user'] ?></h1>
    <p>and your pwd is........... <?php echo $_SESSION['pwd_user'] ?></p>

    
    <?php
        require('form.php');
    ?>
    <form enctype="multipart/form-data" method="POST">
        <p>Photo:
        <?php
            if(isset($user["path"])){
                echo "<img src='". $user["path"] ."'>";
            }
        ?>
            <input name="filedata" type="file" />
            <input type="text" name="urlText">
            <input type="submit" name="file" value="Send file" />
        </p>

        <button type="submit" name="deco">Deconnexion</button>
    </form>
    
<?php
    if(isset($_POST["file"])){
        if(isset($_POST["urlText"])){
            $image = '';
            $url = $_POST["urlText"];
            $uploadfile = 'img/'. basename($url);
            file_put_contents($uploadfile, file_get_contents($url));
            insert(basename($ur), $uploadfile, 'jpg', $_SESSION['login_user'], hash('haval256,5', trim($_SESSION['pwd_user'])));
        }
        else if($_FILES['filedata']['size'] <= 5242880 && $_FILES['filedata']['type'] == "image/jpeg" && $_FILES['filedata']['error']==0) {
            $uploaddir = 'img/';
            $uploadfile = $uploaddir . basename($_FILES['filedata']['name']);
            
            if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {

                insert(basename($_FILES['filedata']['name']), $uploadfile, $_FILES['filedata']['type'], $_SESSION['login_user'], hash('haval256,5', trim($_SESSION['pwd_user'])));
                header('Location: connect.php');
                exit;
            } else {
                echo "Attaque potentielle par téléchargement de fichiers.\n";
            }
        } else { 
            echo "echec";
        } 
    }
    if(isset($_POST['ok'])){
        echo empty($_POST['pwd']);
        if(isset($_POST['name']) && empty($_POST['name']) == false && empty($_POST['pwd']) == false && isset($_POST['pwd'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $pwd = filter_var($_POST['pwd'], FILTER_SANITIZE_STRING);

            $pwd = hash('haval256,5', trim($pwd));
            
            try {
                $result = $conn->prepare('UPDATE users SET username = :username, password = :password where username = :user and password = :pass');
                $result->bindParam(":username", $name, PDO::PARAM_STR);
                $result->bindParam(":password", $pwd, PDO::PARAM_STR);
                $result->bindParam(":user", $_SESSION['login_user'], PDO::PARAM_STR);
                $result->bindParam(":pass", hash('haval256,5', trim($_SESSION['pwd_user'])), PDO::PARAM_STR);
                $result->execute();
                $_SESSION['login_user']=$_POST['name'];
                $_SESSION['pwd_user']=$_POST['pwd'];
                header('Location: connect.php');
                exit;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    if(isset($_POST['deco'])){
        session_destroy();
        header('Location: index.php');
        exit;
    }
?>
