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

    public function getNext()
    {
        throw new \LogicException('End node cannot have next node');
    }

    /**
     * @return bool
     */
    public function isEndNode()
    {
        return true;
    }

}