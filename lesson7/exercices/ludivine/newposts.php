<!DOCTYPE html>
<html>
<head>
	<title>New posts page</title>
</head>

<body>
<h3> Add post </h3>
<form action="profile.php" method="post">
    <div>
        <label for="title">Title* :</label>
        <input type="text" id="title" />
    </div>
    <br />
    <div>
        <label for="body">Body* :</label>
        <textarea name="body"></textarea>
    </div>
    <br />
<h4> Add file </h4>
    <div>
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
      <input name="filedata" type="file" /><br />
    </div>
    <br />
    <div class="button">
        <button type="submit">Valider</button>
    </div>
</form>
</body>
</html>