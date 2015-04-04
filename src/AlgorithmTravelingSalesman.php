<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\Graph;

interface AlgorithmTravelingSalesman
{
    public function setGraph(Graph $graph);
    
    public function computeRoute();
}
