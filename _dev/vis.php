<?php


namespace LokiLevente;


use LokiLevente\SensorData\App\App;

include "../autoload.php";

$app = new App();
$app->run([__FILE__, '../data/sensor.kml']);

$data = [
    'minY' => $app->getNoFiltered()->getMinY(),
    'minX' => $app->getNoFiltered()->getMinX(),
    'maxY' => $app->getNoFiltered()->getMaxY(),
    'maxX' => $app->getNoFiltered()->getMaxX(),
    'filteredPoints' => $app->getPath()->getNodeCoords(),
    'noFilteredPoints' => $app->getNoFiltered()->getNodeCoords(),
];

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<table>
    <tr>
        <th>Without filter</th>
        <th>With filter</th>
    </tr>
    <tr>
        <td><canvas id="c1"></canvas></td>
        <td><canvas id="c2"></canvas></td>
    </tr>
    <tr>
        <td><?php $app->printOutputForNoFiltered(); ?></td>
        <td><?php $app->printOutput(); ?></td>
    </tr>
</table>
    <script>
        function transform(coord)
        {
            var w = window.data.maxX - window.data.minX;
            var h = window.data.maxY - window.data.minY;
            return {
                x: window.size - (coord.x - window.data.minX) / w * window.size,
                y: (coord.y - window.data.minY) / h * window.size
            };
        }
        function drawOnCanvas(canvas, path)
        {
            canvas.width = canvas.height = window.size;
            var ctx = canvas.getContext('2d');

            ctx.beginPath();

            px = transform(path);
            ctx.moveTo(window.size - px.x, window.size - px.y);
            for (i in path) {
                px = transform(path[i]);
                ctx.lineTo(window.size - px.x, window.size - px.y);
            }
            ctx.stroke();
        }
        window.size = 600;
        window.data = <?php echo json_encode($data); ?>;
        window.onload = function() {
            drawOnCanvas(document.getElementById('c1'), window.data.noFilteredPoints);
            drawOnCanvas(document.getElementById('c2'), window.data.filteredPoints);
        }
    </script>
</body>
</html>
