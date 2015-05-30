<?php

namespace Letournel\PathFinder\Algorithms\ShortestPath;

use Letournel\PathFinder\AlgorithmShortestPath;
use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGrid;
use Letournel\PathFinder\Core\NodeMap;
use Letournel\PathFinder\Core\NodePath;
use Letournel\PathFinder\Core\NodePriorityQueueMin;
use Letournel\PathFinder\Distance;

class Dijkstra implements AlgorithmShortestPath
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/Dijkstra%27s_algorithm
     */
    
    private
        $distance,
        $grid;
    
    public function __construct(Distance $distance)
    {
        $this->distance = $distance;
    }
    
    public function setGrid(NodeGrid $grid)
    {
        $this->grid = $grid;
    }
    
    public function computeLength(Node $source, Node $target)
    {
        $shortestPath = $this->computePath($source, $target);
        
        return $shortestPath->computeLength($this->distance);
    }
    
    public function computePath(Node $source, Node $target)
    {
        if(! $this->grid instanceof NodeGrid)
        {
            throw new \RuntimeException('Invalid Grid');
        }
        
        $priorityQueue = new NodePriorityQueueMin();
        $distanceMap = new NodeMap();
        $previousMap = new NodeMap();
        
        $priorityQueue->insert($source, 0);
        $distanceMap->insert($source, 0);
        
        while(! $priorityQueue->isEmpty())
        {
            $node = $priorityQueue->extract();
            
            if($node->getId() === $target->getId())
            {
                return new NodePath($previousMap->lookupFrom($node));
            }
            
            $neighbors = $this->grid->getWalkableNeighbors($node);
            foreach($neighbors as $neighbor)
            {
                $alternativeDistance = $distanceMap->lookup($node) + $this->distance->compute($node, $neighbor);
                if(! $distanceMap->exists($neighbor) || $alternativeDistance < $distanceMap->lookup($neighbor))
                {
                    $priorityQueue->insert($neighbor, $alternativeDistance);
                    $distanceMap->insert($neighbor, $alternativeDistance);
                    $previousMap->insert($neighbor, $node);
                }
            }
        }
        
        return array(); // no path found
    }
}
