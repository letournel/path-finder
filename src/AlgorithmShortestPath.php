<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGrid;

interface AlgorithmShortestPath
{
    public function setGrid(NodeGrid $grid);
    
    public function computePath(Node $source, Node $target);
    
    public function computeLength(Node $source, Node $target);
}
