<?php
namespace ECVChat {

  define('UPLOAD_DIR', __DIR__.'/uploads/');

  function redirect($route){
    header('Location: ' . $route, true, 301);
    exit();  
  }

  function sanitizeString($string){
    $string = (string) $string;

    $string = trim($string);
    $string = filter_var($string, FILTER_SANITIZE_STRING);

    return $string;
  }

  function render($filename, array $vars=[]){
    if(file_exists($filename)){
      foreach ($vars as $name => $value) {
        $$name = $value;
      }

      include $filename;

    } else {
      throw new Exception("Can't render this page", 1);
    }

    return;
  }

  function checkUpload($fieldName){
    return isset($_FILES[$fieldName]) 
      && is_uploaded_file($_FILES[$fieldName]['tmp_name']) 
      && $_FILES[$fieldName]['size'] != 0
      && $_FILES['filedata']['error'] === UPLOAD_ERR_OK
      && preg_match("/\.(jpeg|jpg|png)/", $_FILES[$fieldName]['name']);
  }

  function uploadFile($rawFilename){
    $fullname = basename($rawFilename);
    list($filename, $extension) = explode(".", $fullname);
    $uploadfile = UPLOAD_DIR . $fullname;

    if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
      return [$filename, $extension];
    } else {
      throw new \Exception('The uploaded file couldn\'t not be uploaded', 1);
    }
  }
}

namespace ECVChat\DB {

  function register($username, $password, $email){
    global $conn;

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bindParam(1, trim($username));
    $stmt->bindParam(2, trim($email));
    $stmt->bindParam(3, password_hash($password, PASSWORD_BCRYPT));
    if($stmt->execute()){
      return true;
    } else {
      throw new \Exception("Something went wrong. Username or password is wrong", 1);
    }     
  }

  function login($username, $password){
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if($stmt->execute(array($username))){
      $result = $stmt->fetchAll();      
      if(count($result) === 1 && password_verify($password, $result[0]['password'])) {
        $user = $result[0];

        return $user;
      }
    }
    throw new \Exception("Something went wrong. Username or password is wrong", 1);
  }

  function updateUserImage($userId, $path, $filename, $extension){
    global $conn;

    $conn->beginTransaction();
    $stmt = $conn->prepare("INSERT INTO files (filename, path, extension) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $filename);
    $stmt->bindParam(2, $path);
    $stmt->bindParam(3, $extension);
    $stmt->execute();
    $imageId = $conn->lastInsertId();
    $stmt = $conn->prepare("UPDATE users u SET photo_id = ? where u.id=?");
    $stmt->bindParam(1, $imageId);
    $stmt->bindParam(2, $userId);
    $stmt->execute();
    $conn->commit();

    return $imageId;
  }

  function getLastMessages(){
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM messages 
      INNER JOIN users on messages.user_id = users.id
      LEFT JOIN files on users.photo_id = files.id
      ORDER BY created_at ASC 
      LIMIT 10");
    $result = $stmt->execute();

    return $stmt->fetchAll();
  }


  function addMessage($message){
    global $conn;

    $dateTime = new \DateTime();
    $formattedDatetime = $dateTime->format('Y-m-d H:i:s');

    $conn->beginTransaction();
    $stmt = $conn->prepare("INSERT INTO messages (message, created_at, user_id) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $message);
    $stmt->bindParam(2, $formattedDatetime);
    $stmt->bindParam(3, $_SESSION['id']);
    $stmt->execute();
    $conn->commit();

    return true;
  }
}