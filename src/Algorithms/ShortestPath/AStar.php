<?php

namespace Letournel\PathFinder\Algorithms\ShortestPath;

use Letournel\PathFinder\AlgorithmShortestPath;
use Letournel\PathFinder\Core\Grid;
use Letournel\PathFinder\Core\Heuristic;
use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeMap;
use Letournel\PathFinder\Core\NodePath;
use Letournel\PathFinder\Core\NodePriorityQueueMin;
use Letournel\PathFinder\Distance;

class AStar implements AlgorithmShortestPath
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/A*_search_algorithm
     */
    
    private
        $distance,
        $grid,
        $heuristic;
    
    public function __construct(Distance $distance, Heuristic $heuristic)
    {
        $this->distance = $distance;
        $this->heuristic = $heuristic;
    }
    
    public function setGrid(Grid $grid)
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
        if(! $this->grid instanceof Grid)
        {
            throw new \RuntimeException('Invalid Grid');
        }
        
        $fScorePriorityQueue = new NodePriorityQueueMin();
        $gScoreMap = new NodeMap();
        $openedMap = new NodeMap();
        $closedMap = new NodeMap();
        $previousMap = new NodeMap();
        
        $fScorePriorityQueue->insert($source, 0);
        $gScoreMap->insert($source, 0);
        $openedMap->insert($source);
        
        while(! $fScorePriorityQueue->isEmpty())
        {
            $node = $fScorePriorityQueue->extract();
            $closedMap->insert($node);
            
            if($node->getId() === $target->getId())
            {
                return new NodePath($previousMap->lookupFrom($node));
            }
            
            $neighbors = $this->grid->getWalkableNeighbors($node);
            foreach($neighbors as $neighbor)
            {
                if($closedMap->exists($neighbor))
                {
                    continue;
                }
                
                $gScore = $gScoreMap->lookup($node) + $this->distance->compute($node, $neighbor);
                if(! $openedMap->exists($neighbor) || $gScore < $gScoreMap->lookup($neighbor))
                {
                    $fScore = $gScore + $this->heuristic->compute($node, $target);
                    $fScorePriorityQueue->insert($neighbor, $fScore);
                    $gScoreMap->insert($neighbor, $gScore);
                    $openedMap->insert($neighbor);
                    $previousMap->insert($neighbor, $node);
                }
            }
        }
        
        // no path found
        return array();
    }
}
