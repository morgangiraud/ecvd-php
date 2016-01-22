<?php

require_once 'session.php';
require_once 'connect.php';

require_once 'functions.php';

$message = '';

ecvdphp\render('header.php');

if (isset($_SESSION['id'])) {
    $title = 'Menu';

    $user = ecvdphp\getUserFromSession();
    $posts = ecvdphp\DB\Post\getPostsByUserId($user['id']);
    ecvdphp\render('dashboard.php', array(
        'user' => $user,
        'title' => $title,
        'message' => $message,
        'posts' => $posts,
    ));
} else {
    $title = 'Login page';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            ecvdphp\addFlashMessage('error', 'Something went wrong. You must fill all the fields');
        } else {
            $username = ecvdphp\sanitizeString($_POST['username']); // To improve the ux of the user, you can trim the input
            $password = ecvdphp\sanitizeString($_POST['password']);

            try {
                $user = ecvdphp\DB\login($username, $password);

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                if ($user['photo_id']) {
                    $_SESSION['photo_id'] = $user['photo_id'];
                }

                ecvdphp\addFlashMessage('success', 'You\'ve successfully logged in');
                ecvdphp\redirect('index.php');
            } catch (Exception $e) {
                ecvdphp\addFlashMessage('error', '<p>'.$e->getMessage().'</p>');
            }
        }
    }
    ecvdphp\render('login.php', array(
        'title' => $title,
        'message' => $message,
    ));
}

ecvdphp\render('footer.php');
