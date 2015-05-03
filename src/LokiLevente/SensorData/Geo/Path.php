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

    /**
     * @param Point $point
     * @return Node
     */
    public function addNewNodeByPoint(Point $point)
    {
        $node = new Node($this, $point);
        $node->insertBefore($this->end);

        return $node;
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
        for ($node = $this->start->getNext(); !$node->isEndNode(); $node = $node->getNext()) {
            if (Vector::createFromNodes($node, $node->getNext())->getLength() < 1e-6) {
                $node->delete();
            }
        }
        $del = [];
        for ($node = $this->start->getNext(); !$node->isEndNode(); $node = $node->getNext()) {
            $v1 = Vector::createFromNodes($node, $node->getNext());
            $v2 = Vector::createFromNodes($node->getNext(), $node->getNext()->getNext());
            $v3 = Vector::createFromNodes($node, $node->getNext()->getNext());
            if ($v1->getLength() > 5 * $v3->getLength() && $v2->getLength() > 5 * $v3->getLength()) {
                $del[] = $node->getNext();
            }
        }
        foreach ($del as $node) {
            $node->delete();
        }

        print_r(count($this->getNodes()). "\n");
    }

    /**
     * @return float
     */
    public function getLength()
    {
        $length = 0.0;
        for ($node = $this->start; !$node->isEndNode(); $node = $node->getNext()) {
            $d = $node->getPoint()->getDistanceFrom($node->getNext()->getPoint());
//            echo "$d\n";
            $length += $d;
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