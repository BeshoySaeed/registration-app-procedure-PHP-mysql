<?php

// catch data from register form

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// $img = $_FILES['img'];


echo "<pre>";
print_r($_FILES);
echo "</pre>";

if($_SERVER["REQUEST_METHOD"]== "POST"){

    $fname = validate($_POST['fname']);
    $lname = validate($_POST['lname']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $skill = validate($_POST['skills']);
    $pass = validate($_POST['pass']);
    $cpass = validate($_POST['cpass']);
    $submitBtn = validate($_POST['btn']);
    $img = $_FILES['img'];
    $arrayOfErrors = [];


    //empty check 
    
    if(empty($fname)){
        $arrayOfErrors['empty_fname'] = 'what is your first name';
    }
    if(empty($lname)){
        $arrayOfErrors['empty_lname'] = 'what is your last name';
    }
    if(empty($email)){
        $arrayOfErrors['empty_email'] = 'what is your email';
    }
    if(empty($phone)){
        $arrayOfErrors['empty_phone'] = 'what is your phone number';
    }
    if(empty($pass)){
        $arrayOfErrors['empty_pass'] = 'what is your password';
    }
    if(empty($cpass)){
        $arrayOfErrors['empty_cpass'] = 'please confirm your password';
    }

    // validate length

    if(strlen($fname) < 2 || strlen($lname) < 2){
        $arrayOfErrors['len_name'] = "minimum length 2 character";
    }



    // validate pattern check 

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $arrayOfErrors['valid_email']= "not valid email";
    }

    // check confirm password 

    if($pass !== $cpass){
        $arrayOfErrors['not_equal']= 'confirm password and password not equal';
    }

    

    if(count($arrayOfErrors) > 0){
        // if there is any error
        // unset($_SESSION["errors"]);
        session_start();
        $_SESSION['errors'] = $arrayOfErrors;
        header("location: ../register.php");
    }else{
        // if there is not error

        //     //include connection file 
        require_once('./db.inc.php');

        if($submitBtn == 'submit'){

            move_uploaded_file($_FILES['img']['tmp_name'], 'uploads/'.$_FILES['img']["name"]);  

            try {
                $query = "INSERT INTO students (fname, lname, email, phone, pass,img) 
                            VALUES(?,?,?,?,?,?);";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$fname,$lname, $email, $phone, $pass, $img['name']]);
                header("location: ../login.php");
            } catch (PDOException $e) {
                echo "error ". $e->getMessage();
            }
        }
        elseif($submitBtn == 'update'){
            $id = $_POST['id'];
            try {
                $query = "UPDATE students 
                        SET fname = :fname,
                                    lname = :lname, 
                                    email = :email, 
                                    phone = :phone, 
                                    pass = :pass WHERE id = :id";;
                
                $stmt = $pdo->prepare($query);
                $params = [
                            ':fname' => $fname,
                            ':lname' => $lname,
                            ':email' => $email,
                            ':phone' => $phone,
                            ':pass' => $pass,
                            ':id' => $id
                            ];
                $stmt->execute($params);
                
                header("location: db-views.php");
                
        } catch (PDOException $e) {
                echo "error ". $e->getMessage();
        }
        
        }
}}

function validate($input){
     $validateInput = trim($input);
    $validateInput = stripslashes($input);
    $validateInput = htmlspecialchars($validateInput);

    return $validateInput;
}