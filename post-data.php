<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// GANTI SESUAI DETAIL DATABASE DI HOSTING ONLINE ANDA
$servername = "sqlxxx.infinityfree.com"; // Diberikan oleh hosting
$username   = "if0_xxxxxxx";             // Diberikan oleh hosting
$password   = "PASSWORD_DATABASE_ANDA";  // Password hosting
$dbname     = "if0_xxxxxxx_esp32_monitoring";

$api_key_value = "tPmAT5Ab3j7F9";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = isset($_POST["api_key"]) ? $_POST["api_key"] : "";
    
    if ($api_key === $api_key_value) {
        $adc_value = intval($_POST["adc_value"]);
        $voltage   = floatval($_POST["voltage"]);

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO sensor_data (adc_value, voltage) VALUES (?, ?)");
        $stmt->bind_param("id", $adc_value, $voltage);

        if ($stmt->execute()) {
            echo "Data berhasil disimpan";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "API Key Salah";
    }
} else {
    echo "Metode request harus POST";
}
?>