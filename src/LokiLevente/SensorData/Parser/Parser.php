<?php


namespace LokiLevente\SensorData\Parser;


use LokiLevente\SensorData\Exception\SensorDataException;
use LokiLevente\SensorData\Geo\Coordinate;
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
        foreach (explode(' ', preg_replace('/\s+/', " ", trim($coordinates->textContent))) as $coordStr) {
            $coords = explode(',', $coordStr);
            if (count($coords) == 2) {
                $coordinate = new Coordinate($coords[0], $coords[1]);
            }
            elseif (count($coords) == 3) {
                $coordinate = new Coordinate($coords[0], $coords[1], $coords[2]);
            }
            else {
                throw new SensorDataException('Bad data!');
            }
            $path->addCoordinate($coordinate);
        }

        return $path;
    }

}