<?php

namespace Letournel\PathFinder\Tests\Distances;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Distances\Octile;

class OctileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestCompute
     */
    public function testCompute(Node $a, Node $b, $expected)
    {
        $distance = new Octile();
        
        $this->assertSame($expected, $distance->compute($a, $b));
        $this->assertSame($expected, $distance->compute($b, $a));
    }

    public function providerTestCompute()
    {
        $f = sqrt(2) - 1;
        
        return array(
            array(new Node(1, 1), new Node(2, 2), 1 + 1 * $f),
            array(new Node(1, 1), new Node(5, 5), 4 + 4 * $f),
            array(new Node(1, 1), new Node(5, 4), 4 + 3 * $f),
            array(new Node(1, 1), new Node(5, 3), 4 + 2 * $f),
            array(new Node(1, 1), new Node(5, 2), 4 + 1 * $f),
            array(new Node(2, 5), new Node(5, 2), 3 + 3 * $f),
        );
    }
}