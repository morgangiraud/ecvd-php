<?php
    require("init.php");
    require("header.php");
?>


<body>
    <h1>Register page</h1>

    <?php 
        require('form.php');
        // if($_FILES['filedata']['size'] <= 5242880 && $_FILES['filedata']['type'] == "image/jpeg" && $_FILES['filedata']['error']==0) {
        //     $uploaddir = 'img/';
        //     $uploadfile = $uploaddir . basename($_FILES['filedata']['name']);
            
        //     if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
        //         echo "Le fichier est valide, et a été téléchargé
        //                avec succès. Voici plus d'informations :\n";
        //     } else {
        //         echo "Attaque potentielle par téléchargement de fichiers.
        //               Voici plus d'informations :\n";
        //     }
        // } else { 
        // } 
        
        if(isset($_POST['name']) && empty($_POST['name']) == false && empty($_POST['pwd']) == false && isset($_POST['pwd'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $pwd = filter_var($_POST['pwd'], FILTER_SANITIZE_STRING);

            $pwd = hash('haval256,5', trim($pwd));

            try {
                $result = $conn->prepare('insert into users values (null, :username, null, :password)');
                $result->bindParam(":username", $name, PDO::PARAM_STR);
                $result->bindParam(":password", $pwd, PDO::PARAM_STR);
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