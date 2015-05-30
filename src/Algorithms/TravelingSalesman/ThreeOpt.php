<?php

namespace Letournel\PathFinder\Algorithms\TravelingSalesman;

use Letournel\PathFinder\AlgorithmTravelingSalesman;
use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGraph;
use Letournel\PathFinder\Core\NodePath;

class ThreeOpt implements AlgorithmTravelingSalesman
{
    /*
     * For more info see
     * http://en.wikipedia.org/wiki/3-opt
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
        if(count($this->existingRoute) < 3)
        {
            return $this->existingRoute;
        }
        
        $existingDistance = $this->graph->computeLength($this->existingRoute);
        
        do
        {
            $improvementMade = false;
            foreach($this->existingRoute->getKeys() as $iKey)
            {
                foreach($this->existingRoute->getKeys() as $jKey)
                {
                    foreach($this->existingRoute->getKeys() as $kKey)
                    {
                        if($iKey == $jKey || $iKey == $kKey || $jKey == $kKey)
                        {
                            continue;
                        }
                        $newRoute = $this->threeOptSwap($iKey, $jKey, $kKey);
                        $newDistance = $this->graph->computeLength($newRoute);
                        if($newDistance < $existingDistance)
                        {
                            $this->existingRoute = $newRoute;
                            $existingDistance = $newDistance;
                            $improvementMade = true;
                            
                            break 3;
                        }
                    }
                }
            }
        } while($improvementMade);
        
        return $this->existingRoute;
    }
    
    private function threeOptSwap($iKey, $jKey, $kKey)
    {
        $newRouteNodes = array();
        foreach($this->existingRoute->getKeys() as $key)
        {
            if ($key === $iKey)
            {
                $newRouteNodes[] = $this->existingRoute->getKey($kKey);
            }
            elseif($key === $jKey)
            {
                $newRouteNodes[] = $this->existingRoute->getKey($iKey);
            }
            elseif($key === $kKey)
            {
                $newRouteNodes[] = $this->existingRoute->getKey($jKey);
            }
            else
            {
                $newRouteNodes[] = $this->existingRoute->getKey($key);
            }
        }
        
        return new NodePath($newRouteNodes);
    }
}
