<?php

namespace ecvdphp {

    define('ecvdphp\UPLOAD_DIR', __DIR__.'/uploads/');

    // Utility
    function redirect($route)
    {
        header('Location: '.$route, true, 301);
        exit();
    }

    function sanitizeString($string)
    {
        $string = (string) $string;

        $string = trim($string);
        $string = filter_var($string, FILTER_SANITIZE_STRING);

        return $string;
    }

    // Flash messaging system
    function initFlashMessage()
    {
        if (!isset($_SESSION['flash-message'])) {
            $_SESSION['flash-message'] = [];

            return true;
        }

        return false;
    }

    function hasFlashMessage()
    {
        return isset($_SESSION['flash-message']) && count($_SESSION['flash-message']);
    }

    function addFlashMessage($type, $message)
    {
        initFlashMessage();
        $_SESSION['flash-message'][] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    function displayFlashMessage()
    {
        foreach ($_SESSION['flash-message'] as $key => $data) {
            echo "<p class=\"{$data['type']}\">{$data['message']}</p>";
        }
        unset($_SESSION['flash-message']);
    }

    function render($filename, array $vars = [])
    {
        if (file_exists($filename)) {
            foreach ($vars as $name => $value) {
                $$name = $value;
            }

            include $filename;
        } else {
            throw new Exception("Can't render this page", 1);
        }

        return;
    }

    function getUserFromSession()
    {
        $user = [
            'id' => (int) $_SESSION['id'],
            'username' => (string) $_SESSION['username'],
            'photo_id' => !empty($_SESSION['photo_id']) ? (int) $_SESSION['photo_id'] : null,
        ];

        return $user;
    }

    //
    function checkUploadedFile($filename)
    {
        return isset($_FILES[$filename])
        && is_uploaded_file($_FILES[$filename]['tmp_name'])
        && $_FILES[$filename]['size'] != 0
        && $_FILES['filedata']['error'] === UPLOAD_ERR_OK
        && preg_match("/\.(jpeg|jpg|png)/", $_FILES[$fieldName]['name']);
    }

    function saveUploadedImage($rawFilename)
    {
        $fullname = basename($rawFilename);
        list($filename, $extension) = explode('.', $fullname);
        $uploadfile = UPLOAD_DIR.$fullname;

        if (move_uploaded_file($_FILES['filedata']['tmp_name'], $uploadfile)) {
            return [$filename, $extension];
        } else {
            addFlashMessage('error', 'The uploaded file couldn\'t not be uploadeded');

            return false;
        }
    }

    function downloadImageFromUrl($fileUrl)
    {
        $fullname = basename($fileUrl);
        list($filename, $extension) = explode('.', $fullname);
        $uploadfile = UPLOAD_DIR.$fullname;

        $f = fopen($fileUrl, 'rb');
        if ($f) {
            $content = '';
            while ($data = fread($f, 1024)) {
                $content .= $data;
            }
            fclose($f);
            file_put_contents($uploadfile, $content);

            return [$filename, $extension];
        } else {
            addFlashMessage('error', 'The URL couldn\'t not be found');
        }
    }

}

namespace ecvdphp\DB {

    function register($username, $password, $email)
    {
        global $conn;

        $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->bindParam(1, trim($username));
        $stmt->bindParam(2, trim($email));
        $stmt->bindParam(3, password_hash($password, PASSWORD_BCRYPT));
        if ($stmt->execute()) {
            return true;
        } else {
            throw new \Exception('Something went wrong. Username or password is wrong', 1);
        }
    }

    function login($username, $password)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
        if ($stmt->execute(array($username))) {
            $result = $stmt->fetchAll();
            if (count($result) === 1 && password_verify($password, $result[0]['password'])) {
                $user = $result[0];

                return $user;
            }
        }
        throw new \Exception('Something went wrong. Username or password is wrong', 1);
    }

    function deleteUser($userId)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM users WHERE id=:id');
        $stmt->bindParam(':id', $userId);

        if (!$stmt->execute()) {
            throw new Exception('Could not delete the user', 1);
        }
    }

    function updateUserImage($userId, $filename, $path, $extension)
    {
        global $conn;

        $conn->beginTransaction();
        $stmt = $conn->prepare('INSERT INTO files (filename, path, extension) VALUES (?, ?, ?)');
        $stmt->bindParam(1, $filename);
        $stmt->bindParam(2, $path);
        $stmt->bindParam(3, $extension);
        $stmt->execute();
        $imageId = $conn->lastInsertId();
        $stmt = $conn->prepare('UPDATE users u SET image_id = ? where u.id=?');
        $stmt->bindParam(1, $imageId);
        $stmt->bindParam(2, $userId);
        $stmt->execute();
        $conn->commit();

        return $imageId;
    }
}

namespace ecvdphp\DB\Post {

    function getPostById($postId)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT p.*, u.username, f.filename, f.path, f.extension FROM posts p
            INNER JOIN users u on p.user_id = u.id
            LEFT JOIN files f on p.image_id = f.id
            WHERE p.id=?');
        $stmt->bindParam(1, $postId);
        $result = $stmt->execute();

        return $stmt->fetch();
    }

    function getPostsByUserId($userId)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT p.*, u.username, f.filename, f.path, f.extension FROM posts p
            INNER JOIN users u on p.user_id = u.id
            LEFT JOIN files f on p.image_id = f.id
            WHERE user_id=? 
            ORDER BY created_at DESC');
        $stmt->bindParam(1, $userId);
        $result = $stmt->execute();

        return $stmt->fetchAll();
    }

    function getLastPosts($limit = 10)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT p.*, u.username, f.filename, f.path, f.extension FROM posts p
            INNER JOIN users u on p.user_id = u.id
            LEFT JOIN files f on u.image_id = files.id
            ORDER BY created_at DESC 
            LIMIT ?');
        $stmt->bindParam(1, $limit);
        $result = $stmt->execute();

        return $stmt->fetchAll();
    }

    function insertNewPost($userId, $title, $body, array $imageData = null)
    {
        global $conn;

        $imageId = null;
        $dateTime = new \DateTime();
        $formattedDatetime = $dateTime->format('Y-m-d H:i:s');

        $conn->beginTransaction();
        if (!is_null($imageData)) {
            $stmt = $conn->prepare('INSERT INTO files (filename, path, extension) VALUES (?, ?, ?)');
            $stmt->bindParam(1, $imageData['filename']);
            $stmt->bindParam(2, $imageData['path']);
            $stmt->bindParam(3, $imageData['extension']);
            $stmt->execute();
            $imageId = $conn->lastInsertId();
        }
        $stmt = $conn->prepare('INSERT INTO posts (title, body, user_id, image_id, created_at) VALUES (?, ?, ?, ?, ?)');
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

    function deletePostById($postId)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM posts WHERE p.id=?');
        $stmt->bindParam(1, $postId);
        
        return $stmt->execute();
    }
}
