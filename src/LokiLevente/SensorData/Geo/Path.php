<?php


namespace LokiLevente\SensorData\Geo;


class Path
{

    /**
     * @var Coordinate[]
     */
    private $coordinates = [];

    /**
     * @param Coordinate $coordinate
     */
    public function addCoordinate(Coordinate $coordinate)
    {
        $this->coordinates[] = $coordinate;
    }

    /**
     * @return Coordinate[]
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function filterWrongData()
    {
        // TODO: filter
    }

    /**
     * @return float
     */
    public function getLength()
    {
        $length = 0.0;
        for ($i = 0; $i < count($this->coordinates) - 1; ++$i) {
            $length += $this->coordinates[$i]->getDistanceFrom($this->coordinates[$i + 1]);
        }

        return $length;
    }

}