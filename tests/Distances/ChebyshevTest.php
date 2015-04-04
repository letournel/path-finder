<?php

namespace Letournel\PathFinder\Tests\Distances;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Distances\Chebyshev;

class ChebyshevTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestCompute
     */
    public function testCompute(Node $a, Node $b, $expected)
    {
        $distance = new Chebyshev();
        
        $this->assertSame($expected, $distance->compute($a, $b));
        $this->assertSame($expected, $distance->compute($b, $a));
    }

    public function providerTestCompute()
    {
        return array(
            array(new Node(1, 1), new Node(2, 2), 1),
            array(new Node(1, 1), new Node(5, 5), 4),
            array(new Node(1, 1), new Node(5, 4), 4),
            array(new Node(1, 1), new Node(5, 3), 4),
            array(new Node(1, 1), new Node(5, 2), 4),
            array(new Node(2, 5), new Node(5, 2), 3),
        );
    }
}