<?php


namespace LokiLevente\SensorData\Geo;


class EndNode extends AbstractNode
{

    /**
     * @return Point
     */
    public function getPoint()
    {
        return $this->getPrev()->getPoint();
    }

    /**
     * @return AbstractNode
     */
    public function getNext()
    {
        return $this;
    }

    /**
     * @return bool
     */
    public function isEndNode()
    {
        return true;
    }

}