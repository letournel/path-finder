<?php

namespace Letournel\PathFinder\Tests\Algorithms\ShortestPath;

use Letournel\PathFinder\Algorithms;
use Letournel\PathFinder\Distances;
use Letournel\PathFinder\Tests\Algorithms\AbstractShortestAlgorithmTest;

class DijkstraTest extends AbstractShortestAlgorithmTest
{
    private function buildAlgorithm($syntax)
    {
        $grid = $this->parseGrid($syntax);
        
        $distance = new Distances\Euclidean();
        $algorithm = new Algorithms\ShortestPath\Dijkstra($distance);
        $algorithm->setGrid($grid);
        
        return $algorithm;
    }

    /**
     * @dataProvider providerTestComputeNominal
     */
    public function testCompute($syntax)
    {
        $algorithm = $this->buildAlgorithm($syntax);
        
        $this->assertFoundSamePath($syntax, $algorithm);
    }
}
