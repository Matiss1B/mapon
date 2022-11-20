<?php
$config = parse_ini_file("config.ini", true);
try {
  $conn = new PDO("mysql:host=".$config['DB']['host'].";dbname=".$config['DB']['dbname'], $config['DB']['user'], $config['DB']['pass']);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>