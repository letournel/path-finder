<?php

namespace Letournel\PathFinder\Core;

class NodeGrid
{
    
    private
        $nodes,
        $height,
        $width;
    
    /* Matrix Axes
     * .--------------> j (width) coord y
     * | 1,1 1,2 1,3
     * | 2,1 2,2 2,3
     * | 3,1 ...
     * |
     * i (height) coor x
     */
    public function __construct(array $matrix)
    {
        $this->height = $this->computeHeight($matrix);
        $this->width = $this->computeWidth($matrix);
        $this->nodes = $this->buildNodes($matrix);
    }
    
    private function computeHeight(array $matrix)
    {
        return count($matrix);
    }
    
    private function computeWidth(array $matrix)
    {
        $width = 0;
        foreach($matrix as $line)
        {
            $width = max(count($line), $width);
        }
        
        return $width;
    }
    
    private function buildNodes(array $matrix)
    {
        $nodes = array();
        
        for($i = 0; $i < $this->height; $i++)
        {
            $nodes[$i] = array();
            for($j = 0; $j < $this->width; $j++)
            {
                $walkable = isset($matrix[$i][$j]) ? $matrix[$i][$j] : false;
                $nodes[$i][$j] = new Node($i, $j, $walkable);
            }
        }
        
        return $nodes;
    }
    
    public function getNodes()
    {
        return $this->nodes;
    }
    
    public function buildWalkableNodesList()
    {
        $list = array();
        foreach($this->nodes as $line)
        {
            foreach($line as $node)
            {
                if($node->isWalkable())
                {
                    $list[] = $node;
                }
            }
        }
        
        return $list;
    }
    
    public function getNodeNumber($n)
    {
        $x = floor($n / $this->width);
        $y = $n % $this->width;
        
        return $this->nodes[$x][$y];
    }
    
    public function getNodesNb()
    {
        return $this->height * $this->width;
    }
    
    public function getWidth()
    {
        return $this->width;
    }
    
    public function getHeight()
    {
        return $this->height;
    }
    
    public function getWalkableNeighbors(Node $node)
    {
        if(! $node->isWalkable())
        {
            return array();
        }
        
        $deltas = array(
            array(-1, -1), array(-1, +0), array(-1, +1),
            array(+0, -1),                array(+0, +1),
            array(+1, -1), array(+1, +0), array(+1, +1),
        );
        
        $neighbors = array();
        foreach($deltas as $delta)
        {
            $x = $node->getX() + $delta[0];
            $y = $node->getY() + $delta[1];
            if($this->isWalkableAt($x, $y))
            {
                $neighbors[] = $this->getNodeAt($x, $y);
            }
        }
        
        return $neighbors;
    }
    
    private function getNodeAt($x, $y)
    {
        if(! array_key_exists($x, $this->nodes))
        {
            return null;
        }
        
        if(! array_key_exists($y, $this->nodes[$x]))
        {
            return null;
        }
        
        return $this->nodes[$x][$y];
    }
    
    private function isWalkableAt($x, $y)
    {
        $node = $this->getNodeAt($x, $y);
        if($node instanceof Node)
        {
            return $node->isWalkable();
        }
        
        return false;
    }
}
