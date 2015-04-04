<?php

namespace Letournel\PathFinder\Algorithms\ShortestDistance;

use Letournel\PathFinder\AlgorithmShortestDistance;
use Letournel\PathFinder\Core\Graph;
use Letournel\PathFinder\Core\Grid;
use Letournel\PathFinder\Core\Node;
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
    
    public function setGrid(Grid $grid)
    {
        $this->grid = $grid;
        $this->distanceGraph = new Graph($grid->buildWalkableNodesList());
        $this->distanceGraph->setSymetricMode(false);
    }
    
    public function computeLength(Node $source, Node $target)
    {
        if(! $this->grid instanceof Grid)
        {
            throw new \RuntimeException('Invalid Grid');
        }
        if(! $this->distanceGraph instanceof Graph)
        {
            throw new \RuntimeException('Invalid Graph');
        }
        if(empty($this->distanceGraph->getEdgesFrom($source)))
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
