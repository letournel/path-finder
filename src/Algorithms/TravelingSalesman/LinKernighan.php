<?php

namespace Letournel\PathFinder\Algorithms\TravelingSalesman;

use Letournel\PathFinder\AlgorithmTravelingSalesman;
use Letournel\PathFinder\Core\NodeGraph;

class LinKernighan implements AlgorithmTravelingSalesman
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/Lin%E2%80%93Kernighan_heuristic
     */
    
    private
        $graph;
    
    public function setGraph(NodeGraph $graph)
    {
        $this->graph = $graph;
    }
    
    public function computeRoute()
    {
    }
}
