<?php


namespace LokiLevente\SensorData\Geo;


abstract class AbstractNode
{

    /**
     * @var Path
     */
    protected $path;

    /**
     * @var AbstractNode
     */
    protected $next;

    /**
     * @var AbstractNode
     */
    protected $prev;

    /**
     * @param $path
     */
    function __construct(Path $path)
    {
        $this->path = $path;
    }

    /**
     * @return Point
     */
    abstract public function getPoint();

    /**
     * @return AbstractNode
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @return AbstractNode
     */
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * @return bool
     */
    public function isEndNode()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isStartNode()
    {
        return false;
    }

    /**
     * @return float
     */
    public function getX()
    {
        // TODO: normalize at the edge of the world
        return $this->getPoint()->getLongitude();
    }

    /**
     * @return float
     */
    public function getY()
    {
        // TODO: normalize at the edge of the world
        return $this->getPoint()->getLatitude();
    }

    public function getVector()
    {
        return Vector::createFromNodes($this->getNext(), $this);
    }

    public function delete()
    {
        $this->prev->next = $this->next;
        $this->next->prev = $this->prev;
    }

}