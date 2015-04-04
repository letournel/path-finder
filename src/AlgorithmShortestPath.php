<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\Grid;
use Letournel\PathFinder\Core\Node;

interface AlgorithmShortestPath
{
    public function setGrid(Grid $grid);
    
    public function computePath(Node $source, Node $target);
    
    public function computeLength(Node $source, Node $target);
}
