<?php

namespace Letournel\PathFinder\Core;

class NodeMap implements \Countable, \Iterator
{
    private
        $map;
    
    public function __contruct()
    {
        $this->map = array();
    }
    
    public function count()
    {
        return count($this->map);
    }
    
    public function isEmpty()
    {
        return empty($this->map);
    }
    
    public function rewind()
    {
        rewind($this->map);
    }
    
    public function current()
    {
        return current($this->map);
    }
    
    public function key()
    {
        return key($this->map);
    }
    
    public function next()
    {
        return next($this->map);
    }
    
    public function valid()
    {
        return valid($this->map);
    }
    
    public function lookup(Node $node)
    {
        $id = $node->getId();
        
        if(array_key_exists($id, $this->map))
        {
            return $this->map[$id];
        }
        
        return null;
    }
    
    public function lookupFrom(Node $node)
    {
        $path = array();
        while($node instanceof Node)
        {
            array_unshift($path, $node);
            $node = $this->lookup($node);
            
            if(in_array($node, $path))
            {
                break;
            }
        }
        
        return $path;
    }
    
    public function delete(Node $node)
    {
        $id = $node->getId();
        $value = null;
        
        if(array_key_exists($id, $this->map))
        {
            $value = $this->map[$id];
            unset($this->map[$id]);
        }
        
        return $value;
    }
    
    public function exists(Node $node)
    {
        return array_key_exists($node->getId(), $this->map);
    }
    
    public function insert(Node $node, $value = true)
    {
        $this->map[$node->getId()] = $value;
    }
}
