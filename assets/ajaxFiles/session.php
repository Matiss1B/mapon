<?php
include "../../api/db.php";
include "../../functions.php";
session_start();
$pass = $_POST['pass'];
$username = $_POST['username'];
$test = null;
if(!empty($pass) && !empty($username)){
    //Check if user exist, then set $test to true
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $users = $conn->prepare("SELECT * FROM users");
        $users->execute();

        foreach($users as $user){
            $verify = $user['password'];
            if($username == $user['username'] && password_verify($pass, $verify)){
                $test = true;
                break;
            }else{
                $test = false;
            } 
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    //If user exist, then set $_SESSION['id'];
    if($test == true){
        $id = "";
        $name = "";
        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $users = $conn->prepare("SELECT * FROM users where username ='$username'");
            $users->execute();
            foreach($users as $user){
                $id = $user['id'];
                $name = $user['username'];
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        echo true;
    }elseif($test == false){
        echo "Pass or username is invalid";
    }
}else{
    echo "Please enter username and password";
}