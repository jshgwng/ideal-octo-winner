<?php

$dsn = 'mysql:host=localhost;dbname=phpclassfall2014';
$username = 'root';
$password = '0704073613';

try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error = "Database Error: ";
    $error .= $e->getMessage();
    include('view/error.php');
    exit();
}