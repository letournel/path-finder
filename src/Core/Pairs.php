<?php

namespace Letournel\PathFinder\Core;

class Pairs implements \Iterator
{
    private
        $hasNext,
        $firstIndex,
        $secondIndex,
        $maxIndex,
        $keys,
        $values;
    
    public function __construct(array $items)
    {
        if(count($items) < 2)
        {
            throw new \RuntimeException('Pairs must be initialized with at least two items');
        }
        $this->hasNext = true;
        $this->firstIndex = 0;
        $this->secondIndex = 1;
        $this->maxIndex = count($items);
        
        $this->keys = array();
        $this->values = array();
        foreach($items as $key => $value)
        {
            $this->keys[] = $key;
            $this->values[] = $value;
        }
    }
    
    public function rewind()
    {
        $this->firstIndex = 0;
        $this->secondIndex = 1;
        $this->hasNext = true;
    }
    
    public function current()
    {
        return array($this->values[$this->firstIndex], $this->values[$this->secondIndex]);
    }
    
    public function key()
    {
        return (int) (($this->maxIndex - ($this->firstIndex + 3) / 2) * $this->firstIndex + $this->secondIndex - 1);
    }
    
    public function next()
    {
        $this->secondIndex++;
        if($this->secondIndex >= $this->maxIndex)
        {
            $this->firstIndex++;
            $this->secondIndex = $this->firstIndex + 1;
        }
        if($this->secondIndex >= $this->maxIndex)
        {
            $this->hasNext = false;
            return null;
        }
        
        return $this->current();
    }
    
    public function valid()
    {
        return $this->hasNext;
    }
}
