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
        $this->start->setNext($this->end);
        $this->end->setPrev($this->start);
    }

    public function addPoint(Point $point)
    {
        $node = new Node($this, $point);
        $last = $this->getLastNode();
        $last->setNext($node);
        $node->setPrev($last);
        $node->setNext($this->end);
        $this->end->setPrev($node);
    }

    /**
     * @return AbstractNode
     */
    public function getLastNode()
    {
        return $this->end->getPrev();
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