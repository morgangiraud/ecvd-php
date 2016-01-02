<?php
require_once 'session.php';
require_once 'functions.php';

session_destroy();

ECVChat\redirect('index.php');