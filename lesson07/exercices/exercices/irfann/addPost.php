<?php
    require("session.php");
    require("init.php");
    require("header.php");
	require 'function.php';
?>

<h2>Add post</h2>

   <form enctype="multipart/form-data" method="post">
        <p>title:
            <input type="text" name="title"/>
        </p>
        <p>body:
            <textarea name="body"/></textarea>
        </p>
        	<input name="filedata" type="file" />
        <p>
            <input type="submit" name="ok" value="Valider"/>
        </p>

    </form>

<?php
		
	if(isset($_POST["title"]) && isset($_POST["body"])){
		$user = getUser($_SESSION['login_user'], hash('haval256,5', trim($_SESSION['pwd_user'])));
 		$user_id = $user->fetch()['id'];
        $uploaddir = 'img/';
        $uploadfile = $uploaddir . basename($_FILES['filedata']['name']);
        $lastId = addImage(basename($_FILES['filedata']['name']), $uploadfile, $_FILES['filedata']['type']);
		addPosts($_POST["title"], $_POST["body"], $lastId, $user_id);
	}else{
		die("manque d'information");
	}
?>