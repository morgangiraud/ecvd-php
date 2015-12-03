<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=ecvd_php', 'root', '');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
