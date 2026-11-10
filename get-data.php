<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// GANTI SESUAI DETAIL DATABASE DI HOSTING ONLINE ANDA
$servername = "sqlxxx.infinityfree.com";
$username   = "if0_xxxxxxx";
$password   = "PASSWORD_DATABASE_ANDA";
$dbname     = "if0_xxxxxxx_esp32_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Koneksi database gagal"]);
    exit();
}

$sql = "SELECT id, adc_value, voltage, DATE_FORMAT(reading_time, '%H:%i:%s') as time_formatted 
        FROM sensor_data 
        ORDER BY id DESC LIMIT 15";

$result = $conn->query($sql);
$data = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$data = array_reverse($data);

$conn->close();
echo json_encode($data);
?>