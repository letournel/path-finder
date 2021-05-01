<?php

namespace Letournel\PathFinder\Tests\Algorithms\TravelingSalesman;

use Letournel\PathFinder\Algorithms;
use Letournel\PathFinder\Tests\Algorithms\AbstractTravelingSalesmanTest;

class NearestNeighbourTest extends AbstractTravelingSalesmanTest
{
    /**
     * @dataProvider providerTestComputeNearestNeighbour
     */
    public function testCompute($syntax, $expected)
    {
        $graph = $this->computeGraph($syntax);
        
        $algorithmTravelingSalesman = new Algorithms\TravelingSalesman\NearestNeighbour();
        $algorithmTravelingSalesman->setGraph($graph);
        $route = $algorithmTravelingSalesman->computeRoute();
        
        $this->assertSame($expected, array('length' => (int) floor($graph->computeLength($route) * 1000), 'route' => $route->toString()));
    }

    public function providerTestComputeNearestNeighbour()
    {
        $tests = $this->providerTestComputeNominal();
        
        $tests['no node'][]     = array('length' => 0,      'route' => '');
        $tests['direct node'][] = array('length' => 0,      'route' => '(0,5)');
        $tests['simple 1'][]    = array('length' => 17071,  'route' => '(0,3)->(1,7)->(2,12)->(4,7)');
        $tests['simple 2'][]    = array('length' => 16485,  'route' => '(0,14)->(3,14)->(4,9)->(1,6)->(3,3)');
        $tests['simple 3'][]    = array('length' => 23313,  'route' => '(0,1)->(2,3)->(0,5)->(3,5)->(3,7)->(2,7)->(3,9)->(1,9)->(4,11)');
        $tests['simple 4'][]    = array('length' => 26485,  'route' => '(0,1)->(2,7)->(4,11)->(2,9)->(2,5)');
        $tests['simple 5'][]    = array('length' => 33556,  'route' => '(0,11)->(1,7)->(4,1)->(2,5)->(4,7)->(2,9)->(2,15)');
        $tests['simple 6'][]    = array('length' => 58455,  'route' => '(0,2)->(2,0)->(3,2)->(3,5)->(4,4)->(3,9)->(3,12)->(4,15)->(2,7)->(0,11)');
        $tests['huge 1'][]      = array('length' => 254325, 'route' => '(0,1)->(2,3)->(2,7)->(1,9)->(2,19)->(1,25)->(5,23)->(8,25)->(8,41)->(13,41)->(12,51)->(10,53)->(8,57)->(13,57)->(9,61)->(2,61)->(9,67)->(12,67)->(14,75)->(12,77)->(9,77)->(5,77)->(6,73)->(9,71)->(10,73)->(1,73)->(13,9)->(12,3)');
        $tests['huge 2'][]      = array('length' => 264166, 'route' => '(0,2)->(12,0)->(12,7)->(10,11)->(8,12)->(12,16)->(8,18)->(10,27)->(3,37)->(13,25)->(13,21)->(14,20)->(18,5)->(19,36)->(19,47)->(17,48)->(19,52)->(13,66)->(14,68)->(15,75)->(7,64)->(5,59)->(3,69)->(18,69)->(19,79)');
        
        return $tests;
    }
}
