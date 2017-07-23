<?php

namespace Letournel\PathFinder\Converters\Grid;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGrid;
use Letournel\PathFinder\Core\NodePath;
use Letournel\PathFinder\ConverterGrid;

class ASCIISyntax implements ConverterGrid
{
    const
        FREE = ' ',
        IN   = '>',
        OUT  = '<',
        STEP = '.',
        WALL = 'X';
    
    public function convertToGrid($syntax)
    {
        $matrix = $this->convertToMatrix($syntax);
        
        foreach($matrix as $x => $line)
        {
            foreach($line as $y => $char)
            {
                $matrix[$x][$y] = ($char !== self::WALL) ? 1 : 0;
            }
        }
        
        return new NodeGrid($matrix);
    }
    
    public function convertToMatrix($syntax)
    {
        $matrix = array_filter(explode("\n", $syntax));
        
        foreach($matrix as $key => $line)
        {
            $matrix[$key] = array_filter(str_split($line));
        }
        
        return $matrix;
    }
    
    public function convertToSyntax(NodeGrid $grid)
    {
        $syntax = '';
        
        $nodes = $grid->getNodes();
        foreach($nodes as $line)
        {
            foreach($line as $node)
            {
                $syntax .= ($node->isWalkable() ? self::FREE : self::WALL);
            }
            $syntax .= "\n";
        }
        
        return $syntax;
    }
    
    public function convertToSyntaxWithPath(NodeGrid $grid, NodePath $path)
    {
        $syntax = '';
        
        $nodes = $grid->getNodes();
        foreach($nodes as $line)
        {
            foreach($line as $node)
            {
                if(! $node->isWalkable())
                {
                    $syntax .= self::WALL;
                }
                elseif($node->toString() == $path->getStartNode()->toString())
                {
                    $syntax .= self::IN;
                }
                elseif($node->toString() == $path->getEndNode()->toString())
                {
                    $syntax .= self::OUT;
                }
                elseif($path->contains($node))
                {
                    $syntax .= self::STEP;
                }
                else
                {
                    $syntax .= self::FREE;
                }
            }
            $syntax .= "\n";
        }
        
        return $syntax;
    }
    
    public function findAndCreateNode($syntax, $charToFind)
    {
        $xCount = count($syntax);
        for($x = 0; $x < $xCount; $x++)
        {
            $yCount = count($syntax[$x]);
            for($y = 0; $y < $yCount; $y++)
            {
                if($syntax[$x][$y] === $charToFind)
                {
                    return new Node($x, $y);
                }
            }
        }
    }
    
    public function findAndCreateNodes($syntax, $charToFind)
    {
        $nodes = array();
        $xCount = count($syntax);
        for($x = 0; $x < $xCount; $x++)
        {
            $yCount = count($syntax[$x]);
            for($y = 0; $y < $yCount; $y++)
            {
                if($syntax[$x][$y] === $charToFind)
                {
                    $nodes[] = new Node($x, $y);
                }
            }
        }
        
        return $nodes;
    }
    
    public function generateNodePath($matrix)
    {
        $deltas = array(
            array(-1, -1), array(-1, +0), array(-1, +1),
            array(+0, -1),                array(+0, +1),
            array(+1, -1), array(+1, +0), array(+1, +1),
        );
        
        $node = $this->findAndCreateNode($matrix, self::IN);
        $target = $this->findAndCreateNode($matrix, self::OUT);
        $path = array($node);
        while($node->getId() !== $target->getId())
        {
            $newNode = null;
            foreach($deltas as $delta)
            {
                $x = $node->getX() + $delta[0];
                $y = $node->getY() + $delta[1];
                
                if(! array_key_exists($x, $matrix))
                {
                    continue;
                }
                
                if(! array_key_exists($y, $matrix[$x]))
                {
                    continue;
                }
                
                if($matrix[$x][$y] === self::STEP || $matrix[$x][$y] === self::OUT)
                {
                    $matrix[$x][$y] = self::FREE;
                    $newNode = new Node($x, $y);
                    break;
                }
            }
            
            if(! $newNode instanceof Node)
            {
                throw new \RuntimeException('Path is not continous in the grid');
            }
            
            $node = $newNode;
            $path[] = $node;
        }
        
        return new NodePath($path);
    }
}
