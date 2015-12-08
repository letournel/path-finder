<?php

namespace Letournel\PathFinder\Tests\Converters\Grid;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeGrid;
use Letournel\PathFinder\Core\NodePath;
use Letournel\PathFinder\Converters\Grid\ASCIISyntax;

class ASCIISyntaxTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerExemples
     */
    public function testConvertToGrid($syntax, NodeGrid $expectedGrid)
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
    public function testConvertToSyntax($expectedSyntax, NodeGrid $grid)
    {
        $converter = new ASCIISyntax();
        $syntax = $converter->convertToSyntax($grid);
        $expectedSyntax = $this->removePath($expectedSyntax);
        
        $this->assertSame(
            $expectedSyntax,
            $syntax
        );
    }
    
    /**
     * @dataProvider providerExemples
     */
    public function testConvertToSyntaxWithPath($expectedSyntax, NodeGrid $grid, NodePath $path)
    {
        $converter = new ASCIISyntax();
        $syntax = $converter->convertToSyntaxWithPath($grid, $path);
        
        $this->assertSame(
            $expectedSyntax,
            $syntax
        );
    }
    
    public function providerExemples()
    {
        $tests = array();

        $tests['simple 1'] = array(
            '         .      ' . "\n" .
            '      X >X.     ' . "\n" .
            '      XXXX .    ' . "\n" .
            '    XXXXXXXX.   ' . "\n" .
            '          <.    ' . "\n" ,
            new NodeGrid(
                array(
                    array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                )
            ),
            new NodePath(
                array(
                    new Node(1, 8),
                    new Node(0, 9),
                    new Node(1, 10),
                    new Node(2, 11),
                    new Node(3, 12),
                    new Node(4, 11),
                    new Node(4, 10),
                )
            )
        );

        $tests['simple 2'] = array(
            'XXXXXXXX        ' . "\n" .
            'X  ...>         ' . "\n" .
            'X .             ' . "\n" .
            'X.              ' . "\n" .
            '<               ' . "\n" ,
            new NodeGrid(
                array(
                    array(0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                    array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
                )
            ),
            new NodePath(
                array(
                    new Node(1, 6),
                    new Node(1, 5),
                    new Node(1, 4),
                    new Node(1, 3),
                    new Node(2, 2),
                    new Node(3, 1),
                    new Node(4, 0),
                )
            )
        );
        
        return $tests;
    }
    
    private function removePath($syntax)
    {
        return str_replace(
            array(ASCIISyntax::IN, ASCIISyntax::STEP, ASCIISyntax::OUT),
            ' ',
            $syntax
        );
    }
}
