<?php

namespace Letournel\PathFinder\Algorithms\TravelingSalesman;

use Letournel\PathFinder\AlgorithmTravelingSalesman;
use Letournel\PathFinder\Core\Graph;

class Christofides implements AlgorithmTravelingSalesman
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/Christofides_algorithm
     */
    
    private
        $graph;
    
    public function setGraph(Graph $graph)
    {
        $this->graph = $graph;
    }
    
    public function computeRoute()
    {
    }
}
