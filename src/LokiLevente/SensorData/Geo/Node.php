<?php


namespace LokiLevente\SensorData\Geo;


class Node extends AbstractNode
{

    /**
     * @var Point
     */
    private $point;

    /**
     * @param Path $path
     * @param Point $point
     */
    function __construct(Path $path, Point $point)
    {
        $this->point = $point;
        parent::__construct($path);
    }

    /**
     * @return Point
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param AbstractNode $node
     */
    public function insertBefore(AbstractNode $node)
    {
        $prev = $node->getPrev();
        $prev->next = $this;
        $this->prev = $prev;
        $this->next = $node;
        $node->prev = $this;
    }

}