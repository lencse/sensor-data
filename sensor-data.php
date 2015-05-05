#!/usr/bin/php
<?php

include "autoload.php";

$app = new LokiLevente\SensorData\App\App(__DIR__);
$app->run($argv);
$app->printOutput();
