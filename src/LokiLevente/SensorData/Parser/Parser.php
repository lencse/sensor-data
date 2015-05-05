<?php


namespace LokiLevente\SensorData\Parser;


use LokiLevente\SensorData\Exception\SensorDataException;
use LokiLevente\SensorData\Geo\Point;
use LokiLevente\SensorData\Geo\Path;

class Parser
{

    /**
     * @var string
     */
    private $fileName;

    /**
     * @param string $fileName
     */
    function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return Path
     * @throws SensorDataException
     */
    public function parse()
    {
        $dom = new \DOMDocument();
        $dom->load($this->fileName);
        $coordinates = $dom->getElementsByTagName('coordinates')->item(0);
        $path = new Path();
        $i = 0;
//        $interval = [300, 450];
        foreach (explode(' ', preg_replace('/\s+/', " ", trim($coordinates->textContent))) as $coordStr) {
            $i++;
            $coords = explode(',', $coordStr);
            if (count($coords) == 2 || count($coords) == 3) {
                if (!isset($interval) || $i >= $interval[0] && $i < $interval[1]) {
                    $node = $path->addNewNodeByPoint(new Point($coords[0], $coords[1]));
                }
            }
            else {
                throw new SensorDataException('Bad data!', 1);
            }
        }

        return $path;
    }

}