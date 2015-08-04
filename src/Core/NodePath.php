<?php

namespace Letournel\PathFinder\Core;

use Letournel\PathFinder\Distance;

class NodePath implements \Countable, \Iterator
{
    private
        $path,
        $valid;
    
    public function __construct(array $path)
    {
        $this->path = array();
        $this->valid = true;
        foreach($path as $node)
        {
            if($node instanceof Node)
            {
                $this->path[$node->getId()] = $node;
            }
        }
    }
    
    public function count()
    {
        return count($this->path);
    }
    
    public function current()
    {
        return current($this->path);
    }
    
    public function key()
    {
        return key($this->path);
    }
    
    public function next()
    {
        $this->valid = (next($this->path) !== false);
    }
    
    public function rewind()
    {
        reset($this->path);
        $this->valid = true;
    }
    
    public function valid()
    {
        return $this->valid;
    }
    
    public function getKey($key)
    {
        return $this->path[$key];
    }
    
    public function getKeys()
    {
        return array_keys($this->path);
    }
    
    public function computeLength(Distance $distance)
    {
        $length = 0;
        $prevNode = null;
        foreach($this->path as $node)
        {
            if($prevNode === null)
            {
                $prevNode = $node;
                continue;
            }
            
            $length += $distance->compute($prevNode, $node);
            $prevNode = $node;
        }
        
        return $length;
    }
    
    public function contains(Node $needleNode)
    {
        foreach($this->path as $node)
        {
            if($node->toString() == $needleNode->toString())
            {
                return true;
            }
        }
        
        return false;
    }
    
    public function getStartNode()
    {
        return reset($this->path);
    }
    
    public function getEndNode()
    {
        return end($this->path);
    }
    
    public function toString()
    {
        $nodesString = array();
        foreach($this->path as $node)
        {
            $nodesString[] = $node->toString();
        }
        
        return implode('->', $nodesString);
    }
}
