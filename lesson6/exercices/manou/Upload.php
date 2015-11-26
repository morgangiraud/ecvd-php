<?php ?>
<html>
  <body>
 <form method="post" action="Upload.php" encytype="multipart/form-data">
      <fieldset>
        <legend>Your profile</legend>
        <p>
          <label for="username">Username :</label>
          <input name="username" type="text" id="username" value=""/>
          <br />
          <label for="email">Email :</label>
          <input name="email" type="text" id="email" value=""/>
          <br />
          <label for="password">Password :</label>
          <input name="password" type="password" id="password"/>
          <br />
          <label for="description">Description:</label>
          <textarea name="description" id="description" rows="10" cols="50"></textarea>
        </p>
        <p><input type="submit" value="Envoyer" /></p>
      </fieldset>
      <label for="Upload"></label>
      <input type="file" name="Upload" id="Upload">
      <p>
        <input type="submit" value="Update" />
      </p>
    </form>
    </body>
    </html>