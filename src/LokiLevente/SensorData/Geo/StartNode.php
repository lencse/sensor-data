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


    /**
     * @return AbstractNode
     */
    public function getPrev()
    {
        return $this;
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