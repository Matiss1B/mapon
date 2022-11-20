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
    <title>API Data</title>
</head>
    <body>
        <div class="header bgs1 flex red gap1 alignCenter space-between padL2rem padR2rem padT10px padB10px"> 
            <h1>API Data</h1>
            <div class="flex gap2 alignCenter">
                <a href = "http://localhost:8888/mapon/data.php">List</a>
                <a href = "http://localhost:8888/mapon/home.php">Add</a>
                <a href = "http://localhost:8888/mapon/dataApi.php">API Data</a>
                <p onclick = "logout()"><i class="fa fa-sign-out" aria-hidden="true"></i></p>
            </div>
        </div>
        <div class="w-max flex col alignCenter h-max justifyCenter">
            <div class="table api bgs1">
                <?php 
                include "api/db.php";
                include "functions.php";
                try {
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT * FROM mapon_fuel");
                    $stmt->execute();
                    if($stmt->rowCount()>0){
                        ?>
                        <table>
                            <tr>
                                <th>Date</th>
                                <th>Car nr</th>
                                <th>CAN Odometer</th>
                                <th>GPS Odometer</th>
                                <th>Realtime distance (From VTDT)</th>
                            </tr>
                            <?php
                            foreach($stmt as $row){
                                $carNr = $row['car_nr'];
                                //Loop trought all data an select all unit_id from API
                                $unit_id = file_get_contents("https://mapon.com/api/v1/unit/list.json?key=f94e281f9eff169647620454a2f62839524452a8&car_number=$carNr");
                                $unit_id = json_decode($unit_id);
                                if(!empty($unit_id->data->units[0]->unit_id)){
                                    $unit_id = $unit_id->data->units[0]->unit_id;
                                    if(!empty($unit_id->data->units[0]->label)){
                                    $car = $unit_id->data->units[0]->label;
                                    }else{
                                        $car = "Unknown";
                                    }
                                    $date = date('Y-m-d', strtotime($row['date']));
                                    $time = $row['time'];
                                    //By unit_id select data
                                    $carData = file_get_contents("https://mapon.com/api/v1/unit_data/history_point.json?key=f94e281f9eff169647620454a2f62839524452a8&unit_id=$unit_id&datetime=".$date."T".$time."Z&include[]=can_total_distance&include[]=mileage&include[]=position");
                                    $carData = json_decode($carData);
                                    $carData = $carData->data->units[0];
                                    if(!empty($carData)){
                                        $distance = getDistanceBetweenPoints(57.31844365844227, 25.28392865572822, $carData->position->value->lat, $carData->position->value->lng);
                                        if(!empty($carData->can_total_distance->value) && $carData->mileage->value > 0 ){
                                            ?>
                                            <tr>
                                                <td><?php echo $row['date']?></td>
                                                <td><?php echo $row['car_nr']?></td>
                                                <td><?php echo $carData->can_total_distance->value ?></td>
                                                <td><?php echo $carData->mileage->value?></td>
                                                <td><?php echo round($distance['kilometers'],2)?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                
                            }
                        ?></table><?php
                    }else{
                        ?><h1>No data</h1><?php
                    }
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }?>
            </div>
        </div>
    </body>
    <script src = "assets/script.js"></script>
</html>


