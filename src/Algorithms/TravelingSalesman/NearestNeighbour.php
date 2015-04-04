<?php

namespace Letournel\PathFinder\Algorithms\TravelingSalesman;

use Letournel\PathFinder\Core\Graph;
use Letournel\PathFinder\Core\NodeMap;
use Letournel\PathFinder\Core\NodePath;
use Letournel\PathFinder\AlgorithmTravelingSalesman;

class NearestNeighbour implements AlgorithmTravelingSalesman
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/Nearest_neighbour_algorithm
     */
    
    private
        $graph;
    
    public function setGraph(Graph $graph)
    {
        $this->graph = $graph;
    }
    
    public function computeRoute()
    {
        if(! $this->graph instanceof Graph)
        {
            throw new \RuntimeException('Invalid Graph');
        }
        
        $vertexes = $this->graph->getVertexes();
        if(count($vertexes) <= 2)
        {
            return new NodePath($vertexes);
        }
        
        $vertexFrom = array_shift($vertexes);
        $vertexTo = null;
        
        $pathMap = new NodeMap();
        $pathMap->insert($vertexFrom, $vertexTo);
        while(! empty($vertexes))
        {
            $minimalVertexTo = null;
            $minimalEdge = INF;
            $edges = $this->graph->getEdgesFrom($vertexFrom);
            foreach($edges as $vertexToId => $edge)
            {
                $vertexTo = $this->graph->getVertex($vertexToId);
                if(! $pathMap->exists($vertexTo) && $edge < $minimalEdge)
                {
                    $minimalVertexTo = $vertexTo;
                    $minimalEdge = $edge;
                }
            }
            
            $pathMap->insert($minimalVertexTo, $vertexFrom);
            unset($vertexes[$minimalVertexTo->getId()]);
            $vertexFrom = $minimalVertexTo;
        }
        
        return new NodePath($pathMap->lookupFrom($vertexFrom));
    }
}
