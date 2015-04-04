<?php

namespace Letournel\PathFinder\Tests\Algorithms\ShortestPath;

use Letournel\PathFinder\Algorithms;
use Letournel\PathFinder\Core\Heuristic;
use Letournel\PathFinder\Distance;
use Letournel\PathFinder\Distances;
use Letournel\PathFinder\Tests\Algorithms\AbstractShortestAlgorithmTest;

class AStarTest extends AbstractShortestAlgorithmTest
{
    private function buildAlgorithm($syntax, Distance $heuristicDistance)
    {
        $grid = $this->parseGrid($syntax);
        
        $distance = new Distances\Euclidean();
        $heuristic = new Heuristic($heuristicDistance, 1);
        $algorithm = new Algorithms\ShortestPath\AStar($distance, $heuristic);
        $algorithm->setGrid($grid);
        
        return $algorithm;
    }

    /**
     * @dataProvider providerTestComputeHeuristicZero
     */
    public function testComputeHeuristicZero($syntax)
    {
        $algorithm = $this->buildAlgorithm($syntax, new Distances\Zero());
        
        $this->assertFoundSamePath($syntax, $algorithm);
    }

    /**
     * @dataProvider providerTestComputeHeuristicManhattan
     */
    public function testComputeEuclianHeuristicManhattan($syntax)
    {
        $algorithm = $this->buildAlgorithm($syntax, new Distances\Manhattan());
        
        $this->assertFoundSamePath($syntax, $algorithm);
    }

    /**
     * @dataProvider providerTestComputeHeuristicEuclidean
     */
    public function testComputeEuclianHeuristicEuclidean($syntax)
    {
        $algorithm = $this->buildAlgorithm($syntax, new Distances\Euclidean());
        
        $this->assertFoundSamePath($syntax, $algorithm);
    }

    /**
     * @dataProvider providerTestComputeHeuristicOctile
     */
    public function testComputeEuclianHeuristicOctile($syntax)
    {
        $algorithm = $this->buildAlgorithm($syntax, new Distances\Octile());
        
        $this->assertFoundSamePath($syntax, $algorithm);
    }

    /**
     * @dataProvider providerTestComputeHeuristicChebyshev
     */
    public function testComputeEuclianHeuristicChebyshev($syntax)
    {
        $algorithm = $this->buildAlgorithm($syntax, new Distances\Chebyshev());
        
        $this->assertFoundSamePath($syntax, $algorithm);
    }

    public function providerTestComputeHeuristicZero()
    {
        $tests = $this->providerTestComputeNominal();
        
        return $tests;
    }

    public function providerTestComputeHeuristicManhattan()
    {
        $tests = $this->providerTestComputeNominal();
        
        $tests['simple 6'] = array(
            ' ......         ' . "\n" .
            '.XXXXXX.XXXXXXXX' . "\n" .
            '.X ..XX<X  X    ' . "\n" .
            '.X.X .XXX X   X ' . "\n" .
            ' . X  .........>' . "\n" ,
        );
        
        return $tests;
    }

    public function providerTestComputeHeuristicEuclidean()
    {
        $tests = $this->providerTestComputeNominal();
        
        $tests['simple 2'] = array(
            'XXXXXXXX        ' . "\n" .
            'X     >         ' . "\n" .
            'X    .          ' . "\n" .
            'X....           ' . "\n" .
            '<               ' . "\n" ,
        );
        
        $tests['simple 6'] = array(
            ' ......         ' . "\n" .
            '.XXXXXX.XXXXXXXX' . "\n" .
            '.X ..XX<X  X    ' . "\n" .
            '.X.X .XXX X   X ' . "\n" .
            ' . X  .........>' . "\n" ,
        );
        
        return $tests;
    }

    public function providerTestComputeHeuristicOctile()
    {
        $tests = $this->providerTestComputeNominal();
        
        return $tests;
    }

    public function providerTestComputeHeuristicChebyshev()
    {
        $tests = $this->providerTestComputeNominal();
        
        return $tests;
    }
}
