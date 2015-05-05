<?php


namespace LokiLevente;


use LokiLevente\SensorData\App\App;

include "autoload.php";

$app = new App(__DIR__);
$app->run([__FILE__, 'data/sensor.kml']);

$data = [
    'minY' => $app->getNoFilteredPath()->getMinY(),
    'minX' => $app->getNoFilteredPath()->getMinX(),
    'maxY' => $app->getNoFilteredPath()->getMaxY(),
    'maxX' => $app->getNoFilteredPath()->getMaxX(),
    'filteredPoints' => $app->getFilteredPath()->getNodeCoords(),
    'noFilteredPoints' => $app->getNoFilteredPath()->getNodeCoords(),
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
        <td><?php printf("%.3f km", $app->getNoFilteredPath()->getLength() / 1000) ?></td>
        <td><?php printf("%.3f km", $app->getFilteredPath()->getLength() / 1000) ?></td>
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
            ctx.color = '#000';
            ctx.font = '12px Arial';
            for (i in path) {
                px = transform(path[i]);
                ctx.lineTo(window.size - px.x, window.size - px.y);
//                if (i % 100 == 0) {
//                    ctx.fillText('[' + i + ']', window.size - px.x + 5, window.size - px.y);
//                }
//                ctx.fillText('[' + path[i].x + ', ' + path[i].y + ']', window.size - px.x + 5, window.size - px.y);
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
