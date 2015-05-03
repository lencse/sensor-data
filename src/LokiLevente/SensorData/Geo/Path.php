<?php


namespace LokiLevente\SensorData\Geo;


class Path
{

    /**
     * @var AbstractNode
     */
    private $start;

    /**
     * @var AbstractNode
     */
    private $end;

    function __construct()
    {
        $this->start = new StartNode($this);
        $this->end  = new EndNode($this);
        $this->start->linkWithEndNode($this->end);
    }

    public function addPoint(Point $point)
    {
        $node = new Node($this, $point);
        $node->insertBefore($this->end);
    }

    /**
     * @return Point[]
     */
    public function getPoints()
    {
        return $this->points;
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
        for ($node = $this->start; !$node->isEndNode(); $node = $node->getNext()) {
            $length += $node->getPoint()->getDistanceFrom($node->getNext()->getPoint());
        }

        return $length;
    }

}