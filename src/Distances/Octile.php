<?php

namespace Letournel\PathFinder\Distances;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Distance;

class Octile implements Distance
{
    public function compute(Node $a, Node $b)
    {
        $f = sqrt(2) - 1;
        $dx = abs($a->getX() - $b->getX());
        $dy = abs($a->getY() - $b->getY());
        
        return ($dx < $dy) ? $f * $dx + $dy : $f * $dy + $dx;
    }
}
