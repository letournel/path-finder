<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\NodeGrid;

interface ConverterGrid
{
    public function convertToGrid($syntax);
    
    public function convertToMatrix($syntax);
    
    public function convertToSyntax(NodeGrid $grid);
    
    public function findAndCreateNode($syntax, $charToFind);
    
    public function findAndCreateNodes($syntax, $charToFind);
    
    public function generateNodePath($matrix, $charSource, $charPath, $charTarget);
}
