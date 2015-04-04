<?php

namespace Letournel\PathFinder;

use Letournel\PathFinder\Core\Grid;

interface ConverterGrid
{
    public function convertToGrid($syntax);
    
    public function convertToMatrix($syntax);
    
    public function convertToSyntax(Grid $grid);
    
    public function findAndCreateNode($syntax, $charToFind);
    
    public function findAndCreateNodes($syntax, $charToFind);
    
    public function generateNodePath($matrix, $charSource, $charPath, $charTarget);
}
