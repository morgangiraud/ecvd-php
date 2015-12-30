<?php
require_once 'session.php';
require_once 'functions.php';

session_destroy();

ecvdphp\redirect('index.php');