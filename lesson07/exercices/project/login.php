<div>
    <form method="post" action="">
      <fieldset>
        <legend>Connexion</legend>
        <p>
          <label for="username">Pseudo :</label>
          <input name="username" type="text" id="username" /><br />

          <label for="password">Mot de Passe :</label>
          <input type="password" name="password" id="password" />
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Login" />
      </p>
    </form>
    <div class="error"><?php echo $message; ?></div>
    <a href="signin.php">Sign in!</a>
  </div>