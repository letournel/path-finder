<?php

namespace Letournel\PathFinder\Distances;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Distance;

class Manhattan implements Distance
{
    public function compute(Node $a, Node $b)
    {
        $dx = abs($a->getX() - $b->getX());
        $dy = abs($a->getY() - $b->getY());
        
        return $dx + $dy;
    }
}
