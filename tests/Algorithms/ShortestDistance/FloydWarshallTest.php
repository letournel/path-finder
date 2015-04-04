<?php

namespace Letournel\PathFinder\Tests\Algorithms\ShortestDistance;

use Letournel\PathFinder\Algorithms;
use Letournel\PathFinder\Distances;
use Letournel\PathFinder\Tests\Algorithms\AbstractShortestAlgorithmTest;

class FloydWarshallTest extends AbstractShortestAlgorithmTest
{
    private function buildAlgorithm($syntax)
    {
        $grid = $this->parseGrid($syntax);
        
        $distance = new Distances\Euclidean();
        $algorithm = new Algorithms\ShortestDistance\FloydWarshall($distance);
        $algorithm->setGrid($grid);
        
        return $algorithm;
    }

    /**
     * @dataProvider providerTestComputeNominal
     */
    public function testCompute($syntax)
    {
        $algorithm = $this->buildAlgorithm($syntax);
        
        $this->assertFoundSameLength($syntax, $algorithm);
    }
}
