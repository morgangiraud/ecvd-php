<?php
namespace ecvdphp {

  define('ecvdphp\UPLOAD_DIR', __DIR__.'/uploads/');

  function redirect($dest){
    header('Location: ' . $dest, true, 301);
    exit();  
  }

  function initFlashMessage(){
    if(!isset($_SESSION['flash-message'])){
      $_SESSION['flash-message'] = [];
      return true;
    }
    return false;
  }

  function hasFlashMessage(){
    return (isset($_SESSION['flash-message']) && count($_SESSION['flash-message']));
  }

  function addFlashMessage($type, $message){
    initFlashMessage();
    $_SESSION['flash-message'][] = [
      "type" => $type,
      "message" => $message,
    ];
  }

  function displayFlashMessage(){
    foreach ($_SESSION['flash-message'] as $key => $data) {    
      echo "<p class=\"{$data['type']}\">{$data['message']}</p>";
    }
    unset($_SESSION['flash-message']);
  }

  function checkUploadedFile($filename){
    return isset($_FILES[$filename]) 
      && is_uploaded_file($_FILES[$filename]['tmp_name']) 
      && $_FILES[$filename]['size'] != 0
      && $_FILES['filedata']['error'] === UPLOAD_ERR_OK;
  }

  function saveUploadedImage($rawFilename){
    $fullname = basename($rawFilename);
    list($filename, $extension) = explode(".", $fullname);
    $uploadfile = UPLOAD_DIR . $fullname;

      if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
        return [$filename, $extension];
      } else {
        addFlashMessage('error', 'The uploaded file couldn\'t not be uploadeded');
        return false;
      }
    }

  function downloadImageFromUrl($fileUrl){
    $fullname = basename($fileUrl);
    list($filename, $extension) = explode(".", $fullname);
    $uploadfile = UPLOAD_DIR . $fullname;

    $f = fopen($fileUrl, 'rb');
    if($f){
      $content = "";
      while($data = fread($f, 1024)){
        $content .= $data;
      }
      fclose($f);
      file_put_contents($uploadfile, $content);

      return [$filename, $extension];
    } else {
      addFlashMessage('error', 'The URL couldn\'t not be found');
    }
  }

  function render($filename, $vars){
    if(file_exists($filename)){
      foreach ($vars as $key => $var) {
        $$key = $var;
      }
      var_dump(__DIR__ . $filename);
      include __DIR__ . $filename;
    }
  }
}

namespace ecvdphp\DB {
  function updateUserImage($userId, $filename, $path, $extension){
    global $conn;

    $conn->beginTransaction();
    $stmt = $conn->prepare("INSERT INTO files (filename, path, extension) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $filename);
    $stmt->bindParam(2, $path);
    $stmt->bindParam(3, $extension);
    $stmt->execute();
    $imageId = $conn->lastInsertId();
    $stmt = $conn->prepare("UPDATE users u SET image_id = ? where u.id=?");
    $stmt->bindParam(1, $imageId);
    $stmt->bindParam(2, $userId);
    $stmt->execute();
    $conn->commit();

    return $imageId;
  }
}

namespace ecvdphp\DB\Post {

  function getPostCount(){
    global $conn;

    $stmt = $conn->prepare("SELECT count(1) FROM posts");
    $result = $stmt->execute();

    return $result->fetch();
  }

  function getAllPostPaginated($page=0, $numberPerPage=10){
    global $conn;

    $currentPage = $page * $numberPerPage;

    $stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_at LIMIT ?,?");
    $stmt->bindParam(1, $currentPage, \PDO::PARAM_INT);
    $stmt->bindParam(2, $numberPerPage, \PDO::PARAM_INT);
    $result = $stmt->execute();

    return $result->fetchAll();
  }

  function getPostById($postId){
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
    $stmt->bindParam(1, $postId);
    $result = $stmt->execute();

    return $result->fetch();
  }

  function getPostsByUserId($userId){
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM posts WHERE user_id=?");
    $stmt->bindParam(1, $userId);
    $result = $stmt->execute();

    return $result->fetchAll();
  }

  function insertNewPost($userId, $title, $body, array $imageData = null){
    global $conn;

    $imageId = null;
    $dateTime = new \DateTime();
    $formattedDatetime = $dateTime->format('Y-m-d H:i:s');

    $conn->beginTransaction();
    if(!is_null($imageData)){
      $stmt = $conn->prepare("INSERT INTO files (filename, path, extension) VALUES (?, ?, ?)");
      $stmt->bindParam(1, $imageData['filename']);
      $stmt->bindParam(2, $imageData['path']);
      $stmt->bindParam(3, $imageData['extension']);
      $stmt->execute();
      $imageId = $conn->lastInsertId();  
    }
    $stmt = $conn->prepare("INSERT INTO posts (title, body, user_id, image_id, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $body);
    $stmt->bindParam(3, $userId);
    $stmt->bindParam(4, $imageId);
    $stmt->bindParam(5, $formattedDatetime);
    $stmt->execute();
    $postId = $conn->lastInsertId();

    $conn->commit();

    return $postId;
  }
}