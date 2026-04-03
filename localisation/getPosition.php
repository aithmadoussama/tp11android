<?php
header("Content-Type: application/json");

$code = $_GET['code'] ?? '';

try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=localisation", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT latitude, longitude 
            FROM position 
            WHERE code = :code 
            ORDER BY date_position DESC 
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['code' => $code]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
