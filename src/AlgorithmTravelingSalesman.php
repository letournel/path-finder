<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\NodeGraph;

interface AlgorithmTravelingSalesman
{
    public function setGraph(NodeGraph $graph);
    
    public function computeRoute();
}
