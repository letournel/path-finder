<?php

namespace Letournel\PathFinder\Tests\Core;

use Letournel\PathFinder\Core\Pairs;

class PairsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestPairs
     */
    public function testParis($items, $expectedValues)
    {
        $pairs = new Pairs($items);
        $i = 0;
        foreach($pairs as $key => $values)
        {
            $this->assertSame($i, $key);
            $this->assertSame($expectedValues[$i], $values);
            $i++;
        }
    }

    public function providerTestPairs()
    {
        return array(
            array(
                array('a', 'b'),
                array(array('a', 'b')),
            ),
            array(
                array('a', 'b', 'c'),
                array(array('a', 'b'), array('a', 'c'), array('b', 'c')),
            ),
            array(
                array('a', 'b', 'c', 'd'),
                array(array('a', 'b'), array('a', 'c'), array('a', 'd'), array('b', 'c'), array('b', 'd'), array('c', 'd')),
            ),
            array(
                array(1, 2),
                array(array(1, 2)),
            ),
            array(
                array(1, 2, 3),
                array(array(1, 2), array(1, 3), array(2, 3)),
            ),
            array(
                array(1, 2, 3, 4),
                array(array(1, 2), array(1, 3), array(1, 4), array(2, 3), array(2, 4), array(3, 4)),
            ),
            array(
                array(1, 2, 3, 4, 5),
                array(array(1, 2), array(1, 3), array(1, 4), array(1, 5), array(2, 3), array(2, 4), array(2, 5), array(3, 4), array(3, 5), array(4, 5)),
            ),
            array(
                array(1, 2, 3, 4, 5, 6),
                array(array(1, 2), array(1, 3), array(1, 4), array(1, 5), array(1, 6), array(2, 3), array(2, 4), array(2, 5), array(2, 6), array(3, 4), array(3, 5), array(3, 6), array(4, 5), array(4, 6), array(5, 6)),
            ),
            array(
                array(1 => 'a', 2 => 'b'),
                array(array('a', 'b')),
            ),
            array(
                array(1 => 'a', 2 => 'b', 3 => 'c'),
                array(array('a', 'b'), array('a', 'c'), array('b', 'c')),
            ),
            array(
                array(1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd'),
                array(array('a', 'b'), array('a', 'c'), array('a', 'd'), array('b', 'c'), array('b', 'd'), array('c', 'd')),
            ),
            array(
                array('a' => 1, 'b' => 2),
                array(array(1, 2)),
            ),
            array(
                array('a' => 1, 'b' => 2, 'c' => 3),
                array(array(1, 2), array(1, 3), array(2, 3)),
            ),
            array(
                array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4),
                array(array(1, 2), array(1, 3), array(1, 4), array(2, 3), array(2, 4), array(3, 4)),
            ),
        );
    }
}