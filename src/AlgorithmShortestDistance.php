<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\Grid;
use Letournel\PathFinder\Core\Node;

interface AlgorithmShortestDistance
{
    public function setGrid(Grid $grid);
    
    public function computeLength(Node $source, Node $target);
}
