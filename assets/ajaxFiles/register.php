<?php
include "../../api/db.php";
include "../../functions.php";
$username = $_POST['username'];
$patterns = array ('<','/','=','>');
$username = str_replace($patterns, '', $username); 
$password = $_POST['pass'];
$hashed = password_hash($password, PASSWORD_DEFAULT);
$confirm = $_POST['confirm'];
$test = null;
//Compares if user exists, if not then set $test to true
if(!empty($password) && !empty($username) && !empty($confirm)){
    if($password == $confirm){
        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $users = $conn->prepare("SELECT * FROM users");
            $users->execute();
            $count = $users->rowCount();
            if($count > 0){
                foreach($users as $user){
                    if($username == $user['username']){
                            $test = false;
                        }else{
                            $test = true;
                        }
                }
            }else{
                $test = true;
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        //If user doesnt exist, then it is registered
        if($test == true ){
            try {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO users (username, password ) VALUES ( '$username', '$hashed')";
                $conn->exec($sql);
                echo "1";
              } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
              }
        }else{
            echo "User already exist";
        }
    }else{
        echo"Passwords doesnt match";
    }
}else{
    echo "Please enter password and username";
}