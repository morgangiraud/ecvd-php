<?php
    require("session.php");
    require("init.php");
    require("header.php");
	require 'function.php';

    $post = getPost($_GET['id']);
?>

<h2>Edit post</h2>

   <form enctype="multipart/form-data" method="post">
        <p>title:
            <input type="text" name="title" value="<?php echo $post['title']; ?>" />
        </p>
        <p>body:
            <textarea name="body"/><?php echo $post['body']; ?></textarea>
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
        if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {

            insert(basename($_FILES['filedata']['name']), $uploadfile, $_FILES['filedata']['type'], $_SESSION['login_user'], hash('haval256,5', trim($_SESSION['pwd_user'])));
        } else {
            echo "Attaque potentielle par téléchargement de fichiers.\n";
        }
        $lastId = addImage(basename($_FILES['filedata']['name']), $uploadfile, $_FILES['filedata']['type']);

		editPost($_POST["title"], $_POST["body"], $lastId, $post['id'], $user_id);

        header('Location: editPost.php?id='.$post["id"]);
        exit;
	}else{
		die("manque d'information");
	}
?>