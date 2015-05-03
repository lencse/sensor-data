<?php


namespace LokiLevente;

use LokiLevente\SensorData\Parser\Parser;

include "../autoload.php";

$parser = new Parser(__DIR__ . '/../data/sensor.kml');
$path = $parser->parse();
$path->filterWrongData();

$minLong = $minLat = 1000;
$maxLong = $maxLat = -1000;

$points = [];

foreach ($path->getCoordinates() as $c) {
    if ($c->getLatitude() < $minLat) $minLat = $c->getLatitude();
    if ($c->getLatitude() > $maxLat) $maxLat = $c->getLatitude();
    if ($c->getLongitude() < $minLong) $minLong = $c->getLongitude();
    if ($c->getLongitude() > $maxLong) $maxLong = $c->getLongitude();
    $points[] = ['lat' => $c->getLatitude(), 'long' => $c->getLongitude()];
}

$data = [
    'minLat' => $minLat,
    'minLong' => $minLong,
    'maxLat' => $maxLat,
    'maxLong' => $maxLong,
    'points' => $points,
];

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <script>
        function transform(coord) {
            var w = window.data.maxLat - window.data.minLat;
            var h = window.data.maxLong - window.data.minLong;
            return {
                x: (coord.lat - window.data.minLat) / w * window.size,
                y: window.size - (coord.long - window.data.minLong) / h * window.size
            };
        }
        window.size = 700;
        window.data = <?php echo json_encode($data); ?>;
        window.onload = function() {
            var c = document.createElement('canvas');
            c.width = c.height = window.size;
            var ctx = c.getContext('2d');

            ctx.beginPath();

            px = transform(window.data.points[0]);
            ctx.moveTo(window.size - px.y, window.size - px.x);
            for (i in window.data.points) {
                px = transform(window.data.points[i]);
                ctx.lineTo(window.size - px.y, window.size - px.x);
            }
            ctx.stroke();

            document.body.appendChild(c);
        }
    </script>
</body>
</html>
