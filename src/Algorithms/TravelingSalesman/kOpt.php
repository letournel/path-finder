<?php

namespace Letournel\PathFinder\Algorithms\TravelingSalesman;

use Letournel\PathFinder\AlgorithmTravelingSalesman;
use Letournel\PathFinder\Core\NodeGraph;
use Letournel\PathFinder\Core\NodePath;

class kOpt implements AlgorithmTravelingSalesman
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/k-opt
     */
    
    private
        $existingRoute,
        $graph;
    
    public function setExistingRoute(NodePath $existingRoute)
    {
        $this->existingRoute = $existingRoute;
    }
    
    public function setGraph(NodeGraph $graph)
    {
        $this->graph = $graph;
    }
    
    public function computeRoute()
    {
        throw new \RuntimeException('Not implemented');
    }
}
