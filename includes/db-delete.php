<?php

if (!$_SESSION['email']) {
    header("location: ../login.php");
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = $_GET['id'];

try {
    require_once('./db.inc.php');

    $query = "DELETE FROM students WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    header("location: db-views.php");
} catch (PDOException $e) {
    echo "error caused when try to delete " . $e->getMessage();
}
