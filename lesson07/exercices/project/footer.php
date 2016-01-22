<?php
if(isset($_SESSION['id'])){
    if(!isset($prefix)){
        $prefix = '';    
    }
?>
    <p> 
        <a href="<?php echo $prefix;?>index.php">My dashboard</a>
    </p>
    <p> 
        <a href="<?php echo $prefix;?>profile.php">My profile</a>
    </p>
    <p>
        <a href="<?php echo $prefix;?>logout.php">Logout</a>
    </p>
<?php
}
?>
</body>
</html>