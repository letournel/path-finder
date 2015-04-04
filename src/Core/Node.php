<?php

namespace Letournel\PathFinder\Core;

class Node
{
    private
        $x,
        $y,
        $id,
        $walkable;
    
    public function __construct($x, $y, $walkable = true)
    {
        $this->x = (int) $x;
        $this->y = (int) $y;
        $this->id = sprintf('%d,%d', $this->x, $this->y);
        $this->walkable = (bool) $walkable;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getX()
    {
        return $this->x;
    }
    
    public function getY()
    {
        return $this->y;
    }
    
    public function isWalkable()
    {
        return $this->walkable;
    }
    
    public function toString()
    {
        return sprintf('(%s)', $this->id);
    }
}
