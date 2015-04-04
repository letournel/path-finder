<?php

namespace Letournel\PathFinder\Tests\Distances;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Distances\Euclidean;

class EuclideanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestCompute
     */
    public function testCompute(Node $a, Node $b, $expected)
    {
        $distance = new Euclidean();
        
        $this->assertSame($expected, $distance->compute($a, $b));
        $this->assertSame($expected, $distance->compute($b, $a));
    }

    public function providerTestCompute()
    {
        return array(
            array(new Node(1, 1), new Node(2, 2), sqrt(2)),
            array(new Node(1, 1), new Node(5, 5), sqrt(32)),
            array(new Node(1, 1), new Node(5, 4), sqrt(25)),
            array(new Node(1, 1), new Node(5, 3), sqrt(20)),
            array(new Node(1, 1), new Node(5, 2), sqrt(17)),
            array(new Node(2, 5), new Node(5, 2), sqrt(18)),
        );
    }
}