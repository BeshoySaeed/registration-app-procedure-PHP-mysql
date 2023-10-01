<?php 

// connect to mysql database with php data object module

$dsn = "mysql:host=localhost;dbname=students_data";
$dbUserName = "phpmyadmin";
$dbPassword = "224466";

try {
    $pdo = new PDO($dsn, $dbUserName, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "failed connection ". $e->getMessage();
}