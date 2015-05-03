<?php


namespace LokiLevente\SensorData\Geo;


class Coordinate
{

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @param $longitude
     * @param $latitude
     */
    function __construct($longitude, $latitude)
    {
        $this->longitude = (float) $longitude;
        $this->latitude = (float) $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param Coordinate $other
     * @return float
     */
    public function getDistanceFrom(Coordinate $other)
    {
        $earthRadius = 6371000;

        $lat1 = deg2rad($this->getLatitude());
        $lat2 = deg2rad($other->getLatitude());
        $dLat = deg2rad($other->getLatitude() - $this->getLatitude());
        $dLong = deg2rad($other->getLongitude() - $this->getLongitude());

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) * sin($dLong / 2) * sin($dLong / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

}