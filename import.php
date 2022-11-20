<?php
include "api/db.php";
include "functions.php";
session_start();
$user_id = $_SESSION['id'];
if(isset($_POST['submit'])){
    $fileName = $_FILES['file']['tmp_name'];
    $csvFile = file($fileName);
    $data = [];
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }
    $fuelVal = [
        "Diesel",
        "E95",
        "E98",
        "Electricity",
        "CNG",
        "Extra premium CNG",
        "Premium Diesel",
        "BIOCNG",
        "Super Plus 98",
        "95 Miles",
        "98E0 milesPLUS",
        "D Miles",
        "FUTURA 95",
    ];
    $xml = simplexml_load_file("https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
    $xml = $xml->Cube->Cube->Cube;
    $array = [];
    $empty = false;
    //Loop CSV data
    for($i = 1; $i<count($data); $i++){     
        $timezoneArray = timeChange($data[$i][0],$data[$i][1],$data[$i][9],'Europe/Riga');
        $data[$i][1] = $timezoneArray['newTime'];
        if($data[$i][0] == $timezoneArray['newDate']){
            $data[$i][0] = $timezoneArray['newDate'];
            $date = date('Y-m-d', strtotime($data[$i][0]));


        }
        //Change currency to EUR
        if($data[$i][7] !=="EUR"){
            for($x=0; $x<count($xml);$x++){
                if($data[$i][7] == $xml[$x]['currency']){
                   $data[$i][7] = "EUR";
                   $data[$i][6] = (floatvalue($data[$i][6])/$xml[$x]['rate']);
                }

            }        
       }
        //Check if Product is fuel
        foreach($fuelVal as $fuel){
            if(in_array($fuel,$data[$i])){
                array_push($array,$data[$i]);
                //Upload data
                try {
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO mapon_fuel (date, time, card_nr, car_nr, product, amount, sum, currency, country, country_iso, fuel_station, user_id) values ('".$data[$i][0]."','".$data[$i][1]."','".$data[$i][2]."','".$data[$i][3]."','".$data[$i][4]."','".$data[$i][5]."','".round(floatvalue($data[$i][6]),2)."','".$data[$i][7]."','".$data[$i][8]."','".$data[$i][9]."','".$data[$i][10]."','".$user_id."')";
                    $conn->exec($sql);
                    header("Location: http://localhost:8888/mapon/data.php");
                  } catch(PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                  }
            }
        }

    }
}
?>
