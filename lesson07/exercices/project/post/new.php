<div>
    <form enctype="multipart/form-data" method="post" action="">
      <fieldset>
        <legend>New post</legend>
        <p>
          <label for="title">Title :</label>
          <input name="title" type="text" id="title" value=""/>
          <br />
          <label for="body">Content :</label>
          <textarea name="body" id="body" ></textarea>
          <br />
          <label for="filedata">Picture :</label>
          <input name="filedata" type="file" />
          <br>
          <label for="file-url">Picture URL :</label>
          <input name="file-url" size="64" type="text" />
          <input type="submit" value="Send file" />
        </p>
      </fieldset>
      <p>
        <input type="submit" value="Update" />
      </p>
    </form>
  </div>