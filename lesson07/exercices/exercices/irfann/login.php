<?php
    require("session.php");
    require("init.php");
    require("header.php");
    
    if(isset($_SESSION['login_user']) && isset($_SESSION['pwd_user'])){
        header('Location: connect.php');
        exit;
    }
?>

    <h1>Login page</h1>

    <?php
        require('form.php');

        if(isset($_POST['name']) && empty($_POST['name']) == false && empty($_POST['pwd']) == false && isset($_POST['pwd'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $pwd = filter_var($_POST['pwd'], FILTER_SANITIZE_STRING);

            $pwd = hash('haval256,5', trim($pwd));

            try {
                $result = $conn->prepare('select * from users where username = :username and password = :password');
                $result->bindParam(":username", $name, PDO::PARAM_STR);
                $result->bindParam(":password", $pwd, PDO::PARAM_STR);
                $result->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            if ($result->fetchAll()) {
                $_SESSION['login_user']=$_POST['name'];
                $_SESSION['pwd_user']=$_POST['pwd'];
                header('Location: connect.php');
                exit;
            }
        }
        else {
           print 'no post data to process';
        }
    ?>
<?php 
    require("footer.php");
?>