<?php
session_start();
//If user in not loggen in, he can not see data or upload file
if(empty($_SESSION['id'])){
    header("Location: http://localhost:8888/mapon");
}
    ?>