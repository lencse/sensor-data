<?php

// For testing purposes only

include "../autoload.php";

header('Content-Type: text/plain; charset=UTF-8');

$app = new LokiLevente\SensorData\App\App();
$app->run([__FILE__, '../data/sensor.kml']);
