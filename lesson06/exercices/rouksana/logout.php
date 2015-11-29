<?php
require_once ('session.php');
require_once('function.php');
use Php\Helper;

session_destroy();
Helper::redirect('index.php');
