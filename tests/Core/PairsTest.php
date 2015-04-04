<?php

namespace Letournel\PathFinder\Tests\Core;

use Letournel\PathFinder\Core\Pairs;

class PairsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestPairs
     */
    public function testParis($items, $expectedKeys, $expectedValues)
    {
        $pairs = new Pairs($items);
        $i = 0;
        foreach($pairs as $keys => $values)
        {
            $this->assertSame($expectedKeys[$i], $keys);
            $this->assertSame($expectedValues[$i], $values);
            $i++;
        }
    }

    public function providerTestPairs()
    {
        return array(
            array(
                array('a', 'b'),
                array(array(0, 1)),
                array(array('a', 'b')),
            ),
            array(
                array('a', 'b', 'c'),
                array(array(0, 1), array(0, 2), array(1, 2)),
                array(array('a', 'b'), array('a', 'c'), array('b', 'c')),
            ),
            array(
                array('a', 'b', 'c', 'd'),
                array(array(0, 1), array(0, 2), array(0, 3), array(1, 2), array(1, 3), array(2, 3)),
                array(array('a', 'b'), array('a', 'c'), array('a', 'd'), array('b', 'c'), array('b', 'd'), array('c', 'd')),
            ),
            array(
                array(1, 2),
                array(array(0, 1)),
                array(array(1, 2)),
            ),
            array(
                array(1, 2, 3),
                array(array(0, 1), array(0, 2), array(1, 2)),
                array(array(1, 2), array(1, 3), array(2, 3)),
            ),
            array(
                array(1, 2, 3, 4),
                array(array(0, 1), array(0, 2), array(0, 3), array(1, 2), array(1, 3), array(2, 3)),
                array(array(1, 2), array(1, 3), array(1, 4), array(2, 3), array(2, 4), array(3, 4)),
            ),
            array(
                array(1 => 'a', 2 => 'b'),
                array(array(1, 2)),
                array(array('a', 'b')),
            ),
            array(
                array(1 => 'a', 2 => 'b', 3 => 'c'),
                array(array(1, 2), array(1, 3), array(2, 3)),
                array(array('a', 'b'), array('a', 'c'), array('b', 'c')),
            ),
            array(
                array(1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd'),
                array(array(1, 2), array(1, 3), array(1, 4), array(2, 3), array(2, 4), array(3, 4)),
                array(array('a', 'b'), array('a', 'c'), array('a', 'd'), array('b', 'c'), array('b', 'd'), array('c', 'd')),
            ),
            array(
                array('a' => 1, 'b' => 2),
                array(array('a', 'b')),
                array(array(1, 2)),
            ),
            array(
                array('a' => 1, 'b' => 2, 'c' => 3),
                array(array('a', 'b'), array('a', 'c'), array('b', 'c')),
                array(array(1, 2), array(1, 3), array(2, 3)),
            ),
            array(
                array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4),
                array(array('a', 'b'), array('a', 'c'), array('a', 'd'), array('b', 'c'), array('b', 'd'), array('c', 'd')),
                array(array(1, 2), array(1, 3), array(1, 4), array(2, 3), array(2, 4), array(3, 4)),
            ),
        );
    }
}