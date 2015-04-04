<?php

namespace Letournel\PathFinder\Tests\Distances;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Distances\Zero;

class ZeroTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestCompute
     */
    public function testCompute(Node $a, Node $b, $expected)
    {
        $distance = new Zero();
        
        $this->assertSame($expected, $distance->compute($a, $b));
        $this->assertSame($expected, $distance->compute($b, $a));
    }

    public function providerTestCompute()
    {
        return array(
            array(new Node(1, 1), new Node(2, 2), 0),
            array(new Node(1, 1), new Node(5, 5), 0),
            array(new Node(1, 1), new Node(5, 4), 0),
            array(new Node(1, 1), new Node(5, 3), 0),
            array(new Node(1, 1), new Node(5, 2), 0),
            array(new Node(2, 5), new Node(5, 2), 0),
        );
    }
}