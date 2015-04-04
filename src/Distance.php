<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\Node;

interface Distance
{
    public function compute(Node $a, Node $b);
}
