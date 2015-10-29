<?php
    session_start();
    session_regenerate_id();
    if($_SESSION['login_user'] && $_SESSION['pwd_user']){
        header('Location: connect.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
   <h1>Login page</h1>
   
    <form method="post">
        <p>Name:
            <input type="text" name="name" />
        </p>
        <p>PWD:
            <input type="pwd" name="pwd" />
        </p>
        <p>
            <input type="submit" value="Valider" />
        </p>
    </form>
    
    <?php
        $file = file("users.txt");
        if(isset($_POST['name']) && isset($_POST['pwd'])) {
            $data = $_POST['name'] . './/.' . $_POST['pwd'] . "\n";
            var_dump($file);
            foreach($file as $line) {
                if($line == $data) {
                    echo $data . " is in the users.txt";
                    
                    $_SESSION['login_user']=$_POST['name'];
                    $_SESSION['pwd_user']=$_POST['pwd'];
                }
            }
        }
        else {
           die('no post data to process');
        }
    ?>
</body>
</html>