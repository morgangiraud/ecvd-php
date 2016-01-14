<?php
require_once 'session.php';
require_once 'functions.php';
require_once 'connect.php';

try {
    ecvdphp\DB\deleteUser($_SESSION["id"]);
    ecvdphp\addFlashMessage('success', 'Your account has been deleted');
} catch (Exception $e) {
    ecvdphp\addFlashMessage('error', $e->getMessage());
}
session_destroy();

ecvdphp\redirect('index.php');