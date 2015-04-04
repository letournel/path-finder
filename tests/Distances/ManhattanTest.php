<?php

namespace Letournel\PathFinder\Tests\Distances;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Distances\Manhattan;

class ManhattanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestCompute
     */
    public function testCompute(Node $a, Node $b, $expected)
    {
        $distance = new Manhattan();
        
        $this->assertSame($expected, $distance->compute($a, $b));
        $this->assertSame($expected, $distance->compute($b, $a));
    }

    public function providerTestCompute()
    {
        return array(
            array(new Node(1, 1), new Node(2, 2), 2),
            array(new Node(1, 1), new Node(5, 5), 8),
            array(new Node(1, 1), new Node(5, 4), 7),
            array(new Node(1, 1), new Node(5, 3), 6),
            array(new Node(1, 1), new Node(5, 2), 5),
            array(new Node(2, 5), new Node(5, 2), 6),
        );
    }
}