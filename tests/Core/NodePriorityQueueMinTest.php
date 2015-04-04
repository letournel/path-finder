<?php

namespace Letournel\PathFinder\Tests\Core;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodePriorityQueueMin;

class NodePriorityQueueMinTest extends \PHPUnit_Framework_TestCase
{
    public function testPriorityQueue()
    {
        $priorityQueue = new NodePriorityQueueMin();
        
        $simpleNode = new Node(1, 1);
        $priorityQueue->insert($simpleNode, 0);
        
        $this->assertSame($simpleNode->getId(), $priorityQueue->extract()->getId());
        $this->assertTrue($priorityQueue->isEmpty());
        
        $aNode = new Node(2, 1);
        $bNode = new Node(2, 2);
        $cNode = new Node(2, 3);
        $priorityQueue->insert($aNode, 2);
        $priorityQueue->insert($bNode, 1);
        $priorityQueue->insert($cNode, 3);
        
        $this->assertSame($bNode->getId(), $priorityQueue->extract()->getId());
        $this->assertSame($aNode->getId(), $priorityQueue->extract()->getId());
        $this->assertSame($cNode->getId(), $priorityQueue->extract()->getId());
        $this->assertTrue($priorityQueue->isEmpty());
        
        $dNode = new Node(3, 1);
        $eNode = new Node(3, 2);
        $fNode = new Node(3, 3);
        $priorityQueue->insert($dNode, 0);
        $priorityQueue->insert($eNode, 0);
        $priorityQueue->insert($fNode, 0);
        $priorityQueue->insert($dNode, 3);
        $priorityQueue->insert($eNode, 2);
        $priorityQueue->insert($fNode, 1);
        
        $this->assertSame($fNode->getId(), $priorityQueue->extract()->getId());
        $this->assertSame($eNode->getId(), $priorityQueue->extract()->getId());
        $this->assertSame($dNode->getId(), $priorityQueue->extract()->getId());
        $this->assertTrue($priorityQueue->isEmpty());
    }
}