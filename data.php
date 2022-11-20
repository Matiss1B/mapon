
<?php 
include "assets/ajaxFiles/sessionCheck.php";
$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <title>Document</title>
</head>
    <body>
        <div class="header bgs1 flex red gap1 alignCenter space-between padL2rem padR2rem padT10px padB10px marB5rem"> 
            <h1>List & Summary tables</h1>
            <div class="flex gap2 alignCenter">
                <a href = "http://localhost:8888/mapon/data.php">List</a>
                <a href = "http://localhost:8888/mapon/home.php">Add</a>
                <a href = "http://localhost:8888/mapon/dataApi.php">API Data</a>
                <p onclick = "logout()"><i class="fa fa-sign-out" aria-hidden="true"></i></p>
            </div>
        </div>
        <div class="mainDiv flex col alignCenter">
            <div class="w-max h-max flex col alignCenter">
                <div class="box flex col alignCenter gap1">
                    <h1>List</h1>
                    <div class="flex w-max alignCenter search padL2rem gap1 padT10px padB10px">
                            <h1>Filter/Search By:</h1>
                            <button class = "btn" onclick = "product()">Product</button>
                            <button  class = "btn"onclick = "country()">Country</button>
                            <button  class = "btn" onclick = "card()">Card</button>
                            <button  class = "btn" onclick = "date()">Date</button>
                            <div class="sortInput"></div>
                    </div>
                    <div class="list table bgs1">
                            <?php
                        //Get all data from DB by user
                        include "api/db.php";
                        include "functions.php";
                        try {
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $conn->prepare("SELECT * FROM mapon_fuel WHERE user_id = $user_id");
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            if($count>0){
                                ?>
                                <table>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Card Nr.</th>
                                        <th>Car Nr.</th>
                                        <th>Product</th>
                                        <th>Amount</th>
                                        <th>Price</th>
                                        <th>Price per unity</th>
                                        <th>Currency</th>
                                        <th>Country</th>
                                        <th>Country_ISO</th>
                                        <th>Fuel Station</th>
                                    </tr>
                                    <?php foreach($stmt as $row){?>
                                        <tr>
                                            <td><?php echo $row['date'] ?></td>
                                            <td><?php echo $row['time'] ?></td>
                                            <td><?php echo $row['card_nr'] ?></td>
                                            <td><?php echo $row['car_nr'] ?></td>
                                            <td><?php echo $row['product'] ?></td>
                                            <td><?php echo $row['amount'] ?></td>
                                            <td><?php echo $row['sum'] ?></td>
                                            <td><?php echo round((floatvalue($row['sum'])/floatvalue($row['amount'])),2)?></td>
                                            <td><?php echo $row['currency'] ?></td>
                                            <td><?php echo $row['country'] ?></td>
                                            <td><?php echo $row['country_iso'] ?></td>
                                            <td><?php echo $row['fuel_station'] ?></td>
                                        </tr>
                                    <?php }?>
                                </table>
                                <?php
                            }else{
                                ?><h1>No data for this user</h1><?php
                            }   
                        } catch(PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }?>
                    </div>
                    <h1>Summary</h1>
                </div>
            </div>
            <div class="summary">
                    <?php
                    //Select data for summary
                    try {
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $types = $conn->prepare("SELECT DISTINCT product from mapon_fuel WHERE user_id = $user_id");
                        $types->execute();
                        $count = $types->rowCount();
                        if($count>0){
                            ?>
                            <table class = "bgs1">
                                <tr>
                                    <th>FuelType</th>
                                    <th>Amount</th>
                                    <th>Cost</th>
                                </tr>
                                <?php
                            $totalSum = $conn->prepare("SELECT sum(amount) as fuel , sum(sum) as price from mapon_fuel WHERE user_id = $user_id");
                            $totalSum->execute();
                            foreach ($types as $type){
                                $fuelType = $type['product'];
                                $sum = $conn->prepare("SELECT sum(amount) as fuel, sum(sum) as price  from mapon_fuel WHERE product = '$fuelType' AND user_id = $user_id");
                                $sum->execute();
                                foreach ($sum as $fuel){
                                    ?>
                                    <tr>
                                        <td><?php echo $fuelType ?></td>
                                        <td><?php echo $fuel['fuel'] ?></td>
                                        <td><?php echo round($fuel['price'],2)?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            foreach($totalSum as $sum){
                                ?>
                                <div class="totalSummary">
                                    <tr class = "total">
                                        <td>Total</td>
                                        <td><?php echo $sum['fuel'] ?></td>
                                        <td><?php echo round($sum['price'],2)?></td>
                                    </tr>
                                </div>
                                <?php
                            }
                        }else{
                            ?><h1>No data for this user</h1><?php
                        }
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }?>
                <table>
            </div>
        </div>
    </body>
</html>
<script src = "assets/script.js"></script>
<?php

