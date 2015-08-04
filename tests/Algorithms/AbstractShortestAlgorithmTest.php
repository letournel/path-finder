<?php

namespace Letournel\PathFinder\Tests\Algorithms;

use Letournel\PathFinder\AlgorithmShortestDistance;
use Letournel\PathFinder\AlgorithmShortestPath;
use Letournel\PathFinder\Converters\Grid\ASCIISyntax;
use Letournel\PathFinder\Distances;

abstract class AbstractShortestAlgorithmTest extends \PHPUnit_Framework_TestCase
{
    public function providerTestComputeNominal()
    {
        return array(
            'simple line' =>  array(
                '>.....<',
            ),
            'simple colunm' =>  array(
                '>' . "\n" .
                '.' . "\n" .
                '.' . "\n" .
                '.' . "\n" .
                '.' . "\n" .
                '<' . "\n" ,
            ),
            'simple 1' => array(
                '         .      ' . "\n" .
                '      X >X.     ' . "\n" .
                '      XXXX .    ' . "\n" .
                '    XXXXXXXX.   ' . "\n" .
                '          <.    ' . "\n" ,
            ),
            'simple 2' => array(
                'XXXXXXXX        ' . "\n" .
                'X  ...>         ' . "\n" .
                'X .             ' . "\n" .
                'X.              ' . "\n" .
                '<               ' . "\n" ,
            ),
            'simple 3' => array(
                '      <.        ' . "\n" .
                '    X X.X X     ' . "\n" .
                '    X X.X X     ' . "\n" .
                '    X X.X X     ' . "\n" .
                '        .>      ' . "\n" ,
            ),
            'simple 4' => array(
                '        ...     ' . "\n" .
                '    XXX.XXX.    ' . "\n" .
                '    X X<X X.    ' . "\n" .
                '    X XXX X.    ' . "\n" .
                '         >.     ' . "\n" ,
            ),
            'simple 5' => array(
                '    ...         ' . "\n" .
                '   .XXX.XXXXXXXX' . "\n" .
                '   .X X<X X     ' . "\n" .
                '   .X XXX X     ' . "\n" .
                '    ...........>' . "\n" ,
            ),
            'simple 6' => array(
                ' ......         ' . "\n" .
                '.XXXXXX.XXXXXXXX' . "\n" .
                '.X . XX<X  X    ' . "\n" .
                '.X.X. XXX X   X ' . "\n" .
                ' . X ..........>' . "\n" ,
            ),
        );
    }

    protected function assertFoundSamePath($syntax, AlgorithmShortestPath $algorithm)
    {
        $converter = new ASCIISyntax();
        $matrix = $converter->convertToMatrix($syntax);
        $source = $converter->findAndCreateNode($matrix, ASCIISyntax::IN);
        $target = $converter->findAndCreateNode($matrix, ASCIISyntax::OUT);
        $expectedPath = $converter->generateNodePath($matrix);
        $path = $algorithm->computePath($source, $target);
        
        $this->assertSame($expectedPath->toString(), $path->toString());
    }

    protected function assertFoundSameLength($syntax, AlgorithmShortestDistance $algorithm)
    {
        $converter = new ASCIISyntax();
        $distance = new Distances\Euclidean();
        $matrix = $converter->convertToMatrix($syntax);
        $source = $converter->findAndCreateNode($matrix, ASCIISyntax::IN);
        $target = $converter->findAndCreateNode($matrix, ASCIISyntax::OUT);
        $expectedPath = $converter->generateNodePath($matrix);
        $expectedLength = $expectedPath->computeLength($distance);
        $length = $algorithm->computeLength($source, $target);
        
        $this->assertSame($expectedLength, $length);
    }
    
    protected function parseGrid($syntax)
    {
        $converter = new ASCIISyntax();
        
        return $converter->convertToGrid($syntax);
    }
}
