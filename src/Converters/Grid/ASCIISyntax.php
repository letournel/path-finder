<?php

namespace Letournel\PathFinder\Converters\Grid;

use Letournel\PathFinder\Core\Grid;
use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodePath;
use Letournel\PathFinder\ConverterGrid;

class ASCIISyntax implements ConverterGrid
{
    const
        FREE = ' ',
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
        
        return new Grid($matrix);
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
    
    public function convertToSyntax(Grid $grid)
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
    
    public function findAndCreateNode($syntax, $charToFind)
    {
        for($x = 0; $x < count($syntax); $x++)
        {
            for($y = 0; $y < count($syntax[$x]); $y++)
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
        for($x = 0; $x < count($syntax); $x++)
        {
            for($y = 0; $y < count($syntax[$x]); $y++)
            {
                if($syntax[$x][$y] === $charToFind)
                {
                    $nodes[] = new Node($x, $y);
                }
            }
        }
        
        return $nodes;
    }
    
    public function generateNodePath($matrix, $charSource, $charPath, $charTarget)
    {
        $deltas = array(
            [-1, -1], [-1, +0], [-1, +1],
            [+0, -1],           [+0, +1],
            [+1, -1], [+1, +0], [+1, +1],
        );
        
        $node = $this->findAndCreateNode($matrix, $charSource);
        $target = $this->findAndCreateNode($matrix, $charTarget);
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
                
                if($matrix[$x][$y] === $charPath || $matrix[$x][$y] === $charTarget)
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
