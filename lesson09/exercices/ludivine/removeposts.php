<?php
	require("session.php");
    require("init.php");
    require("header.php");
	require 'functions.php';

	removePosts($_GET["id"]);
	header('Location: connect.php');
    exit;
?>