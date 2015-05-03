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
     * @return AbstractNode[]
     */
    public function getNodes()
    {
        $ret = [];
        for ($node = $this->start; !$node->isEndNode(); $node = $node->getNext()) {
            $ret[] = $node;
        }

        return $ret;
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

    /**
     * @return float
     */
    public function getMinX()
    {
        $ret = 1000.0;
        for ($node = $this->start; !$node->isEndNode(); $node = $node->getNext()) {
            if ($ret > $node->getX()) {
                $ret = $node->getX();
            }
        }

        return $ret;
    }

    /**
     * @return float
     */
    public function getMaxX()
    {
        $ret = -1000.0;
        for ($node = $this->start; !$node->isEndNode(); $node = $node->getNext()) {
            if ($ret < $node->getX()) {
                $ret = $node->getX();
            }
        }

        return $ret;
    }

    /**
     * @return float
     */
    public function getMinY()
    {
        $ret = 1000.0;
        for ($node = $this->start; !$node->isEndNode(); $node = $node->getNext()) {
            if ($ret > $node->getY()) {
                $ret = $node->getY();
            }
        }

        return $ret;
    }

    /**
     * @return float
     */
    public function getMaxY()
    {
        $ret = -1000.0;
        for ($node = $this->start; !$node->isEndNode(); $node = $node->getNext()) {
            if ($ret < $node->getY()) {
                $ret = $node->getY();
            }
        }

        return $ret;
    }


}