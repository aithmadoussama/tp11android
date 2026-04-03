<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'service/PositionService.php';
    include_once 'classe/Position.php';
    create();
}

function create()
{
    $data = json_decode(file_get_contents("php://input"), true);



    if (
        isset($data['latitude']) &&
        isset($data['longitude']) &&
        isset($data['date_position']) &&
        isset($data['code']) &&
        isset($data['imei'])
    ) {

        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $datePosition = $data['date_position'];
        $imei = $data['imei'];
        $code = $data['code'];

        $service = new PositionService();
        $position = new Position(null, $latitude, $longitude, $datePosition, $imei, $code);
        $service->create($position);

        echo "Position enregistrée avec succès ✅";
    } else {
        echo "Erreur : données JSON manquantes ❌";
    }
}
