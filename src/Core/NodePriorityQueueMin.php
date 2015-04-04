<?php

namespace Letournel\PathFinder\Core;

class NodePriorityQueueMin implements \Countable
{
    private
        $map,
        $queue;
    
    public function __contruct()
    {
        $this->map = array();
        $this->queue = array();
    }
    
    public function count()
    {
        return count($this->queue);
    }
    
    public function isEmpty()
    {
        return empty($this->queue);
    }
    
    public function lookup(Node $node)
    {
        $id = $node->getId();
        
        if(array_key_exists($id, $this->queue))
        {
            return $this->queue[$id];
        }
        
        return null;
    }
    
    public function extract()
    {
        reset($this->queue);
        $id = key($this->queue);
        $node = $this->map[$id];
        
        unset($this->map[$id]);
        unset($this->queue[$id]);
        
        return $node;
    }
    
    public function insert(Node $node, $priority)
    {
        $this->queue[$node->getId()] = $priority;
        $this->map[$node->getId()] = $node;
        asort($this->queue);
    }
}
