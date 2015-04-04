<?php

namespace Letournel\PathFinder\Distances;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Distance;

class Zero implements Distance
{
    public function compute(Node $a, Node $b)
    {
        return 0;
    }
}
