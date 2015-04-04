<?php

namespace Letournel\PathFinder\Core;

use Letournel\PathFinder\Distance;

class Heuristic
{
    private
        $distance,
        $weight;
    
    public function __construct(Distance $distance, $weight = 1)
    {
        $this->distance = $distance;
        $this->weight = (float) $weight;
    }
    
    public function compute(Node $node, Node $target)
    {
        return $this->weight * $this->distance->compute($node, $target);
    }
}
