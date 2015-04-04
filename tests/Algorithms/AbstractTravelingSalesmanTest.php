<?php

namespace Letournel\PathFinder\Tests\Algorithms;

use Letournel\PathFinder\Algorithms;
use Letournel\PathFinder\Converters\Grid\ASCIISyntax;
use Letournel\PathFinder\Core\Graph;
use Letournel\PathFinder\Core\Pairs;
use Letournel\PathFinder\Distances;

abstract class AbstractTravelingSalesmanTest extends \PHPUnit_Framework_TestCase
{
    public function providerTestComputeNominal()
    {
        return array(
            'no node' => array(
                '                ' . "\n" ,
            ),
            'direct node' => array(
                '     o          ' . "\n" ,
            ),
            'simple 1' => array(
                '   o            ' . "\n" .
                '      Xo X      ' . "\n" .
                '      XXXX  o   ' . "\n" .
                '    XXXXXXXX    ' . "\n" .
                '       o        ' . "\n" ,
            ),
            'simple 2' => array(
                'XXXXXXXX      o ' . "\n" .
                'X     o         ' . "\n" .
                'X               ' . "\n" .
                'X  o          o ' . "\n" .
                '         o      ' . "\n" ,
            ),
            'simple 3' => array(
                ' o   o          ' . "\n" .
                '    X X XoX     ' . "\n" .
                '   oX XoX X     ' . "\n" .
                '    XoXoXoX     ' . "\n" .
                '           o    ' . "\n" ,
            ),
            'simple 4' => array(
                ' o              ' . "\n" .
                '    XXX XXX     ' . "\n" .
                '    XoXoXoX     ' . "\n" .
                '    X XXX X     ' . "\n" .
                '           o    ' . "\n" ,
            ),
            'simple 5' => array(
                '           o    ' . "\n" .
                '    XXXoXXXXXXXX' . "\n" .
                '    XoX XoX    o' . "\n" .
                '    X XXX X     ' . "\n" .
                ' o     o        ' . "\n" ,
            ),
            'simple 6' => array(
                '  o        o    ' . "\n" .
                ' XXXXXX XXXXXXXX' . "\n" .
                'oX   XXoX  X    ' . "\n" .
                ' XoX oXXXoX o X ' . "\n" .
                '   Xo          o' . "\n" ,
            ),
            'huge 1' => array(
                ' o                                                                              ' . "\n" .
                'X X X X XoX X X X X X X XoX X X X X X X X X X X X X X X X X X X X X X X XoX X X ' . "\n" .
                'X XoX XoX X X X X XoX X X X X X X X X X X X X X X X X X X X XoX X X X X X X X X ' . "\n" .
                'X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X ' . "\n" .
                'X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X ' . "\n" .
                'X X X X X X X X X X X XoX X X X X X X X X X X X X X X X X X X X X X X X X X XoX ' . "\n" .
                'X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X XoX X X ' . "\n" .
                '                                                                                ' . "\n" .
                'X X X X X X X X X X X X XoX X X X X X X XoX X X X X X X XoX X X X X X X X X X X ' . "\n" .
                'X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X XoX X XoX XoX X XoX ' . "\n" .
                'X X X X X X X X X X X X X X X X X X X X X X X X X X XoX X X X X X X X X XoX X X ' . "\n" .
                'X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X X ' . "\n" .
                'X XoX X X X X X X X X X X X X X X X X X X X X X X XoX X X X X X X XoX X X X XoX ' . "\n" .
                'X X X X XoX X X X X X X X X X X X X X X XoX X X X X X X XoX X X X X X X X X X X ' . "\n" .
                '                                                                           o    ' . "\n" ,
            ),
            'huge 2' => array(
                '  o                                                                             ' . "\n" .
                ' XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX' . "\n" .
                ' X   XX X  X     X   XX X  X     X   XX X  X     X   XX X  X     X   XX X  X    ' . "\n" .
                ' X X  XXX X   X  X X  XXX X   X  X X oXXX X   X  X X  XXX X   X  X X oXXX X   X ' . "\n" .
                '   X               X               X               X               X            ' . "\n" .
                '                                                           o                    ' . "\n" .
                ' XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX' . "\n" .
                ' X   XX X  X     X   XX X  X     X   XX X  X     X   XX X  X    oX   XX X  X    ' . "\n" .
                ' X X  XXX X o X  XoX  XXX X   X  X X  XXX X   X  X X  XXX X   X  X X  XXX X   X ' . "\n" .
                '   X               X               X               X               X            ' . "\n" .
                '           o               o                                                    ' . "\n" .
                ' XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX' . "\n" .
                'oX   XXoX  X    oX   XX X  X     X   XX X  X     X   XX X  X     X   XX X  X    ' . "\n" .
                ' X X  XXX X   X  X X oXXXoX   X  X X  XXX X   X  X X  XXX X   X  XoX  XXX X   X ' . "\n" .
                '   X               Xo              X               X               Xo           ' . "\n" .
                '                                                                           o    ' . "\n" .
                ' XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX XXXXXX XXXXXXXX' . "\n" .
                ' X   XX X  X     X   XX X  X     X   XX X  X    oX   XX X  X     X   XX X  X    ' . "\n" .
                ' X X oXXX X   X  X X  XXX X   X  X X  XXX X   X  X X  XXX X   X  X X oXXX X   X ' . "\n" .
                '   X               X               Xo          o   Xo              X           o' . "\n" ,
            ),
        );
    }
    
    protected function computeGraph($syntax)
    {
        $converter = new ASCIISyntax();
        $grid = $converter->convertToGrid($syntax);
        $distance = new Distances\Euclidean();
        $algorithmShortestDistance = new Algorithms\ShortestDistance\Dijkstra($distance);
        $algorithmShortestDistance->setGrid($grid);
        
        $matrix = $converter->convertToMatrix($syntax);
        $nodes = $converter->findAndCreateNodes($matrix, 'o');
        $graph = new Graph($nodes);
        if(count($nodes) < 2)
        {
            return $graph;
        }
        
        $pairs = new Pairs($nodes);
        foreach($pairs as $pair)
        {
            list($source, $target) = $pair;
            $length = $algorithmShortestDistance->computeLength($source, $target);
            $graph->createEdgeBetween($source, $target, $length);
        }
        return $graph;
    }
}