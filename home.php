<?php
include "assets/ajaxFiles/sessionCheck.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Fuel Task</title>
</head>
<body>
    <div class="header bgs1 flex red gap1 alignCenter space-between padL2rem padR2rem padT10px padB10px"> 
        <h1>Fuel Task</h1>
        <div class="flex gap2 alignCenter">
            <a href = "http://localhost:8888/mapon/data.php">List</a>
            <a href = "http://localhost:8888/mapon/home.php">Add</a>
            <a href = "http://localhost:8888/mapon/dataApi.php">API Data</a>
            <p onclick = "logout()"><i class="fa fa-sign-out" aria-hidden="true"></i></p>
        </div>
    </div>
    <div class="flex col w-max h-max justifyCenter alignCenter gap1 home">
        <h1>Welcome, <?php echo $_SESSION['name'];?></h1>
        <h1>CSV Upload</h1>
        <div class="csv bgs2 pad5rem">
            <form action="import.php" method="post" enctype="multipart/form-data">
                <input type="file" name="file" class = "upload" accept=".csv">
                <button name = "submit" class = "btn pad10px">Upload</button>
            </form>
        </div>
    </div>
</body>
<script src = "assets/script.js"></script>
</html>






