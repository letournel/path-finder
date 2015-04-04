<?php

namespace Letournel\PathFinder\Tests\Converters\Grid;

use Letournel\PathFinder\Core\Grid;
use Letournel\PathFinder\Converters\Grid\ASCIISyntax;

class ASCIISyntaxTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerExemples
     */
    public function testConvertToGrid($syntax, Grid $expectedGrid)
    {
        $converter = new ASCIISyntax();
        $grid = $converter->convertToGrid($syntax);
        
        $this->assertSame(
            json_encode($expectedGrid->getNodes()),
            json_encode($grid->getNodes())
        );
    }
    
    /**
     * @dataProvider providerExemples
     */
    public function testConvertToSyntax($expectedSyntax, Grid $grid)
    {
        $converter = new ASCIISyntax();
        $syntax = $converter->convertToSyntax($grid);
        
        $this->assertSame(
            $expectedSyntax,
            $syntax
        );
    }

    public function providerExemples()
    {
        $tests = array();

        $tests['simple 1'] = array(
            '                ' . "\n" .
            '      X  X      ' . "\n" .
            '      XXXX      ' . "\n" .
            '    XXXXXXXX    ' . "\n" .
            '                ' . "\n" ,
            new Grid(
                array(
                    array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                )
            )
        );

        $tests['simple 2'] = array(
            'XXXXXXXX        ' . "\n" .
            'X               ' . "\n" .
            'X               ' . "\n" .
            'X               ' . "\n" .
            '                ' . "\n" ,
            new Grid(
                array(
                    array(0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                )
            )
        );

        return $tests;
    }
}
