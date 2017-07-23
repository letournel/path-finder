<?php

namespace Letournel\PathFinder\Converters\Grid;

use Letournel\PathFinder\Core\NodeGrid;
use Letournel\PathFinder\ConverterGrid;

class DeclarativeSyntax implements ConverterGrid
{
    public function convertToGrid($syntax)
    {
        throw new \RuntimeException('Not implemented');
    }
	
    public function convertToMatrix($syntax)
    {
        throw new \RuntimeException('Not implemented');
    }
    
    public function convertToSyntax(NodeGrid $map)
    {
        throw new \RuntimeException('Not implemented');
    }
    
    public function convertToSyntaxWithPath(NodeGrid $grid, NodePath $path)
    {
        throw new \RuntimeException('Not implemented');
    }
    
    public function findAndCreateNode($syntax, $charToFind)
    {
        throw new \RuntimeException('Not implemented');
    }
    
    public function findAndCreateNodes($syntax, $charToFind)
    {
        throw new \RuntimeException('Not implemented');
    }
    
    public function generateNodePath($matrix)
    {
        throw new \RuntimeException('Not implemented');
    }
}
