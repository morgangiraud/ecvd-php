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

		editPost($_POST["title"], $_POST["body"], 14,3);
	}else{
		die("manque d'information");
	}
?>