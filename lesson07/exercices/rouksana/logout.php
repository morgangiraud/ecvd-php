<?php
require_once ('session.php');
require_once('function.php');

session_destroy();
User\redirect('index.php');
