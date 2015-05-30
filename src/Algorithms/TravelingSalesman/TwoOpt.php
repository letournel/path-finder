<?php

namespace Letournel\PathFinder\Algorithms\TravelingSalesman;

use Letournel\PathFinder\AlgorithmTravelingSalesman;
use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGraph;
use Letournel\PathFinder\Core\NodePath;

class TwoOpt implements AlgorithmTravelingSalesman
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/2-opt
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
        if(! $this->graph instanceof NodeGraph)
        {
            throw new \RuntimeException('Invalid Graph');
        }
        if(! $this->existingRoute instanceof NodePath)
        {
            throw new \RuntimeException('Invalid ExistingRoute');
        }
        if(count($this->existingRoute) < 2)
        {
            return $this->existingRoute;
        }
        
        $existingDistance = $this->graph->computeLength($this->existingRoute);
        
        do
        {
            $improvementMade = false;
            foreach($this->existingRoute->getKeys() as $iKey)
            {
                foreach($this->existingRoute->getKeys() as $kKey)
                {
                    if($iKey == $kKey)
                    {
                        continue;
                    }
                    $newRoute = $this->twoOptSwap($iKey, $kKey);
                    $newDistance = $this->graph->computeLength($newRoute);
                    if($newDistance < $existingDistance)
                    {
                        $this->existingRoute = $newRoute;
                        $existingDistance = $newDistance;
                        $improvementMade = true;
                        
                        break 2;
                    }
                }
            }
        } while($improvementMade);
        
        return $this->existingRoute;
    }
    
    private function twoOptSwap($iKey, $kKey)
    {
        $newRouteNodes = array();
        foreach($this->existingRoute->getKeys() as $key)
        {
            if ($key === $iKey)
            {
                $newRouteNodes[] = $this->existingRoute->getKey($kKey);
            }
            elseif($key === $kKey)
            {
                $newRouteNodes[] = $this->existingRoute->getKey($iKey);
            }
            else
            {
                $newRouteNodes[] = $this->existingRoute->getKey($key);
            }
        }
        
        return new NodePath($newRouteNodes);
    }
}
