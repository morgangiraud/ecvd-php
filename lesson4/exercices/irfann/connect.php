<?php session_start(); ?>

    <h1>CONNECT to <?php echo $_SESSION['login_user'] ?></h1>
    <p>and your pwd is........... <?php echo $_SESSION['pwd_user'] ?></p>
    
    <form method="POST">
        <button type="submit" name="deco">Deconnexion</button>
    </form>
    
<?php
    if(isset($_POST['deco'])){
        session_destroy();
        header('Location: index.php');
        exit;
    }
?>
