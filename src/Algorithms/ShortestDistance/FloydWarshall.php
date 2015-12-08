<?php

namespace Letournel\PathFinder\Algorithms\ShortestDistance;

use Letournel\PathFinder\AlgorithmShortestDistance;
use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGraph;
use Letournel\PathFinder\Core\NodeGrid;
use Letournel\PathFinder\Distance;

class FloydWarshall implements AlgorithmShortestDistance
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/Floyd%E2%80%93Warshall_algorithm
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
            $this->computeDistanceGraph();
        }
        
        return $this->distanceGraph->getEdgeBetween($source, $target);
    }
    
    private function computeDistanceGraph()
    {
        $nbNodes = $this->grid->getNodesNb();
        for($i = 0; $i < $nbNodes; $i++)
        {
            $iNode = $this->grid->getNodeNumber($i);
            $neighbors = $this->grid->getWalkableNeighbors($iNode);
            foreach($neighbors as $neighbor)
            {
                $alternativeDistance = $this->distance->compute($iNode, $neighbor);
                if($alternativeDistance < $this->distanceGraph->getEdgeBetween($iNode, $neighbor))
                {
                    $this->distanceGraph->createEdgeBetween($iNode, $neighbor, $alternativeDistance);
                }
            }
        }
        
        for($k = 0; $k < $nbNodes; $k++)
        {
            $kNode = $this->grid->getNodeNumber($k);
            if(! $kNode->isWalkable())
            {
                continue;
            }
            for($i = 0; $i < $nbNodes; $i++)
            {
                $iNode = $this->grid->getNodeNumber($i);
                if(! $iNode->isWalkable())
                {
                    continue;
                }
                for($j = 0; $j < $nbNodes; $j++)
                {
                    $jNode = $this->grid->getNodeNumber($j);
                    if(! $jNode->isWalkable())
                    {
                        continue;
                    }
                    $alternativeDistance = $this->distanceGraph->getEdgeBetween($iNode, $kNode) + $this->distanceGraph->getEdgeBetween($kNode, $jNode);
                    if($alternativeDistance < $this->distanceGraph->getEdgeBetween($iNode, $jNode))
                    {
                        $this->distanceGraph->createEdgeBetween($iNode, $jNode, $alternativeDistance);
                    }
                }
            }
        }
    }
}
