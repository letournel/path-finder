<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGrid;

interface AlgorithmShortestDistance
{
    public function setGrid(NodeGrid $grid);
    
    public function computeLength(Node $source, Node $target);
}
