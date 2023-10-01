<?php

$id = $_GET['id'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(!$_SESSION['email']){
    header("location: register.html");
}

try {
    require_once('./includes/db.inc.php');

    $query = "SELECT * FROM students WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // print_r($data);
    // header("location: db-views.php");


} catch (PDOException $e) {
    echo "error caused when try to delete ". $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./register.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <form action="./includes/dbh-access.php" method="post" >
            <p>Edit form</p>
            <input type="text" hidden value="<?= $data['id'] ?>" name="id" >
            <label for="fname">first name</label>
            <input type="text" id="fname" name="fname" value="<?= $data['fname'] ?>" >
            <label for="lname">last name</label>
            <input type="text" id="lname" name="lname" value="<?= $data['lname'] ?>" >
            <label for="email">email</label>
            <input type="text" id="email" name="email" value="<?= $data['email'] ?>" >
            <label for="phone">phone</label>
            <input type="tel" id="phone" name="phone" value="<?= $data['phone'] ?>" >
            <label >skills</label>
            <select name="skills" >
                <option value="js">Js</option>
                <option value="css">Css</option>
                <option value="html">HTML</option>
                <option value="db">database</option>
                <option value="php">PHP</option>
                <option value="lar">larvel</option>
            </select>
            <label for="pass">password</label>
            <input type="password" id="pass" name="pass" value="<?= $data['pass'] ?>" >
            <label for="cpass">confirm password</label>
            <input type="password" id="cpass" name="cpass" value="<?= $data['pass'] ?>" > 
            <input type="submit" value="update" class="submit" name="btn">
        </form>
    </div>        
</body>
</html>