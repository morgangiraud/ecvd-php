<?php
require_once ('session.php');
require_once('function.php');

session_destroy();
Php\redirect('index.php');
