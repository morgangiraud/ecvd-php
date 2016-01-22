<?php

require_once '../session.php';
require_once '../functions.php';
require_once '../connect.php';

if (!isset($_SESSION['id'])) { // The user must be logged in
    ecvdphp\redirect('../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = ($_POST['title'] != null) ? trim($_POST['title']) : '';
    $body = ($_POST['body'] != null) ? trim($_POST['body']) : '';
    $imageData = null;

    $urlExploded = explode('/', $_SERVER['REQUEST_URI']);
    array_pop($urlExploded);
    $path = implode('/', $urlExploded).'/uploads';
    if (ecvdphp\checkUploadedFile('filedata')) {
        if (!preg_match('/jpeg|jpg|png/', $_FILES['filedata']['type'])) {
            ecvdphp\addFlashMessage('error', 'You can only upload jpeg or png files');
        } else {
            list($filename, $extension) = ecvdphp\saveUploadedImage($_FILES['filedata']['name']);
            $imageData = array(
                'filename' => $filename,
                'path' => $path,
                'extension' => $extension,
            );
        }
    } elseif (isset($_POST['file-url']) && !empty($_POST['file-url']) && (bool) filter_var($_POST['file-url'], FILTER_VALIDATE_URL)) {
        $fileUrl = $_POST['file-url'];

        list($filename, $extension) = ecvdphp\downloadImageFromUrl($fileUrl);
        $imageData = array(
            'filename' => $filename,
            'path' => $path,
            'extension' => $extension,
        );
    } else {
        ecvdphp\addFlashMessage('error', 'The uploaded file couldn\'t be found');
    }

    try {
        $postId = ecvdphp\DB\Post\insertNewPost($_SESSION['id'], $title, $body, $imageData);
        ecvdphp\addFlashMessage('success', 'You\'ve successfully created a new post');
        ecvdphp\redirect('show.php?id='.$postId);
    } catch (Exception $e) {
        ecvdphp\addFlashMessage('error', $e->getMessage());
    }
}

ecvdphp\render('../header.php', [
    'prefix' => "../"
]);

ecvdphp\render('new.php');

ecvdphp\render('../footer.php', [
    'prefix' => "../"
]);
