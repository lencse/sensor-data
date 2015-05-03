<?php


namespace LokiLevente\SensorData\Geo;


class Vector
{

    /**
     * @var float
     */
    private $x;

    /**
     * @var float
     */
    private $y;

    /**
     * @param float $x
     * @param float $y
     */
    function __construct($x, $y)
    {
        $this->x = (float) $x;
        $this->y = (float) $y;
    }

    public static function createFromNodes(AbstractNode $from, AbstractNode $to)
    {
        return new self($to->getX() - $from->getX(), $to->getY() - $from->getY());
    }

    public function getLength()
    {
        return sqrt($this->x * $this->x + $this->y * $this->y);
    }

}