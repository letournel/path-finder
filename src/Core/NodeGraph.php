<?php

namespace Letournel\PathFinder\Core;

class NodeGraph
{
    private
        $edges,
        $vertexes,
        $symetric;
    
    public function __construct(array $nodes)
    {
        $this->edges = array();
        $this->vertexes = array();
        $this->symetric = true;
        foreach($nodes as $node)
        {
            if($node instanceof Node)
            {
                $this->vertexes[$node->getId()] = $node;
            }
        }
    }
    
    public function setSymetricMode($symetric)
    {
        $this->symetric = $symetric;
        
        return $this;
    }
    
    public function createEdgeBetween(Node $a, Node $b, $value)
    {
        $aId = $a->getId();
        $bId = $b->getId();
        if(! array_key_exists($aId, $this->vertexes) || ! array_key_exists($bId, $this->vertexes))
        {
            return;
        }
        if($aId === $bId)
        {
            return;
        }
        
        if($this->symetric === true)
        {
            $this->edges[$bId][$aId] = (float) $value;
        }
        $this->edges[$aId][$bId] = (float) $value;
    }
    
    public function getEdgeBetween(Node $a, Node $b)
    {
        $aId = $a->getId();
        $bId = $b->getId();
        if(! array_key_exists($aId, $this->vertexes) || ! array_key_exists($bId, $this->vertexes))
        {
            return null;
        }
        if($aId === $bId)
        {
            return 0;
        }
        if(! array_key_exists($aId, $this->edges))
        {
            return INF;
        }
        if(! array_key_exists($bId, $this->edges[$aId]))
        {
            return INF;
        }
        
        return $this->edges[$aId][$bId];
    }
    
    public function existsEdgeBetween(Node $a, Node $b)
    {
        $aId = $a->getId();
        $bId = $b->getId();
        if(! array_key_exists($aId, $this->vertexes) || ! array_key_exists($bId, $this->vertexes))
        {
            return false;
        }
        if($aId === $bId)
        {
            return false;
        }
        if(! array_key_exists($aId, $this->edges))
        {
            return false;
        }
        if(! array_key_exists($bId, $this->edges[$aId]))
        {
            return false;
        }
        
        return true;
    }
    
    public function containsEdges(Node $a, Node $b)
    {
        $aId = $a->getId();
        $bId = $b->getId();
        
        return array_key_exists($aId, $this->vertexes) && array_key_exists($bId, $this->vertexes);
    }
    
    public function removeEdgeBetween(Node $a, Node $b)
    {
        $aId = $a->getId();
        $bId = $b->getId();
        if(! array_key_exists($aId, $this->vertexes) || ! array_key_exists($bId, $this->vertexes))
        {
            return;
        }
        
        unset($this->edges[$aId][$bId]);
        unset($this->edges[$bId][$aId]);
    }
    
    public function getVertexes()
    {
        return $this->vertexes;
    }
    
    public function getVertex($id)
    {
        if(array_key_exists($id, $this->vertexes))
        {
            return $this->vertexes[$id];
        }
        
        return null;
    }
    
    public function getEdgesFrom(Node $vertexFrom)
    {
        $edges = array();
        $vertexFromId = $vertexFrom->getId();
        foreach($this->vertexes as $vertexToId => $vertexTo)
        {
            if(isset($this->edges[$vertexFromId][$vertexToId]))
            {
                $edges[$vertexToId] = $this->edges[$vertexFromId][$vertexToId];
            }
        }
        
        return $edges;
    }
    
    public function getEdgesTo(Node $vertexTo)
    {
        $edges = array();
        $vertexToId = $vertexTo->getId();
        foreach($this->vertexes as $vertexFromId => $vertexFrom)
        {
            if(isset($this->edges[$vertexFromId][$vertexToId]))
            {
                $edges[$vertexToId] = $this->edges[$vertexFromId][$vertexToId];
            }
        }
        
        return $edges;
    }
    
    public function computeLength(NodePath $route)
    {
        $length = 0;
        $prevNode = null;
        foreach($route as $node)
        {
            if($prevNode === null)
            {
                $prevNode = $node;
                continue;
            }
            
            $length += $this->getEdgeBetween($prevNode, $node);
            $prevNode = $node;
        }
        
        return $length;
    }
}
