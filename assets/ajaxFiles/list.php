<?php
include "../../api/db.php";
include "../../functions.php";
session_start();
$sort = $_POST['sort'];
$where = $_POST['where'];
$user_id = $_SESSION['id'];
//Select and returns data based on what the user has entered
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM mapon_fuel WHERE user_id = $user_id AND $where LIKE '%$sort%'");
    $stmt->execute();
    $count = $stmt->rowCount();
    if($count > 0){
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
                <th>Price per</th>
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
    <?php }else{
        ?><h1>No data for this user</h1><?php
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }