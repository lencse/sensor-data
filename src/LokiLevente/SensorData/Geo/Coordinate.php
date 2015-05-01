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
     * @var float
     */
    private $altitude;

    /**
     * @param float $longitude
     * @param float $latitude
     * @param float $altitude
     */
    function __construct($longitude, $latitude, $altitude = 0.0)
    {
        $this->longitude = (float) $longitude;
        $this->latitude = (float) $latitude;
        $this->altitude = (float) $altitude;
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
     * @return float
     */
    public function getAltitude()
    {
        return $this->altitude;
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