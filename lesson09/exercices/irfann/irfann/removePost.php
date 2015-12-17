<?php
	require("session.php");
    require("init.php");
    require("header.php");
	require 'function.php';

	deletePost($_GET["id"]);
	header('Location: connect.php');
    exit;

?>