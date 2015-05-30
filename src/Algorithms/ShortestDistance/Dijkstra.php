<?php

namespace Letournel\PathFinder\Algorithms\ShortestDistance;

use Letournel\PathFinder\AlgorithmShortestDistance;
use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGraph;
use Letournel\PathFinder\Core\NodeGrid;
use Letournel\PathFinder\Core\NodePriorityQueueMin;
use Letournel\PathFinder\Distance;

class Dijkstra implements AlgorithmShortestDistance
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/Dijkstra%27s_algorithm
     */
    
    private
        $distance,
        $distanceGraph,
        $grid;
    
    public function __construct(Distance $distance)
    {
        $this->distance = $distance;
    }
    
    public function setGrid(NodeGrid $grid)
    {
        $this->grid = $grid;
        $this->distanceGraph = new NodeGraph($grid->buildWalkableNodesList());
        $this->distanceGraph->setSymetricMode(false);
    }
    
    public function computeLength(Node $source, Node $target)
    {
        if(! $this->grid instanceof NodeGrid)
        {
            throw new \RuntimeException('Invalid Grid');
        }
        if(! $this->distanceGraph instanceof NodeGraph)
        {
            throw new \RuntimeException('Invalid Graph');
        }
        
        $edges = $this->distanceGraph->getEdgesFrom($source);
        if(empty($edges))
        {
            $this->computeDistanceGraph(array($source));
        }
        
        return $this->distanceGraph->getEdgeBetween($source, $target);
    }
    
    private function computeDistanceGraph(array $nodesList)
    {
        foreach($nodesList as $source)
        {
            $priorityQueue = new NodePriorityQueueMin();
            $priorityQueue->insert($source, 0);
            
            while(! $priorityQueue->isEmpty())
            {
                $node = $priorityQueue->extract();
                
                $neighbors = $this->grid->getWalkableNeighbors($node);
                foreach($neighbors as $neighbor)
                {
                    $alternativeDistance = $this->distanceGraph->getEdgeBetween($source, $node) + $this->distance->compute($node, $neighbor);
                    if(! $this->distanceGraph->existsEdgeBetween($source, $neighbor) || $alternativeDistance < $this->distanceGraph->getEdgeBetween($source, $neighbor))
                    {
                        $priorityQueue->insert($neighbor, $alternativeDistance);
                        $this->distanceGraph->createEdgeBetween($source, $neighbor, $alternativeDistance);
                    }
                }
            }
        }
    }
}
