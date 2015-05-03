<?php


namespace LokiLevente\SensorData\Geo;


class StartNode extends AbstractNode
{

    /**
     * @return Point
     */
    public function getPoint()
    {
        return $this->getNext()->getPoint();
    }


    public function getPrev()
    {
        throw new \LogicException('Start node cannot have previous node');
    }

    /**
     * @return bool
     */
    public function isStartNode()
    {
        return true;
    }

    /**
     * @param EndNode $endNode
     */
    public function linkWithEndNode(EndNode $endNode)
    {
        $this->next = $endNode;
        $endNode->prev = $this;
    }

}