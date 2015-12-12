<?php

require('session.php');
require('header.php');
require('functions.php');
require('connect_db.php');
?>


<?php


            if(isset($_POST['nom']) && empty($_POST['nom']) == false && isset($_POST['mdp']) && empty($_POST['mdp']) == false && isset($_POST['email']) && empty($_POST['email']) == false) {

            try {
                $result = $conn->prepare('insert into users values (null, :username, :email, :password, null)');
                $result->bindParam(":username", $_POST['nom'], PDO::PARAM_STR);
                $result->bindParam(":password", $_POST['mdp'], PDO::PARAM_STR);
                $result->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
                $result->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
    }
        else {
           die('no post data to process');
        }
?>

</body>
</html>