<?php

namespace Letournel\PathFinder\Tests\Core;

use Letournel\PathFinder\Core\Node;
use Letournel\PathFinder\Core\NodeMap;
use Letournel\PathFinder\Core\NodePath;

class NodeMapTest extends \PHPUnit_Framework_TestCase
{
    public function testMap()
    {
        $map = new NodeMap();
        $node = new Node(1, 1);
        $aNode = new Node(2, 1);
        $bNode = new Node(2, 2);
        $cNode = new Node(2, 3);
        $dNode = new Node(3, 1);
        $eNode = new Node(3, 2);
        $fNode = new Node(3, 3);
        
        $map->insert($node, 10);
        $this->assertTrue($map->exists($node));
        $this->assertSame($map->lookup($node), 10);
        $this->assertSame($map->delete($node), 10);
        $this->assertTrue($map->isEmpty());
        $this->assertFalse($map->exists($node));
        
        $map->insert($aNode, 'a');
        $map->insert($bNode, 'c');
        $map->insert($cNode, 'b');
        $this->assertSame($map->lookup($aNode), 'a');
        $this->assertSame($map->lookup($bNode), 'c');
        $this->assertSame($map->lookup($cNode), 'b');
        
        $map->insert($bNode, 'b');
        $map->insert($cNode, 'c');
        $this->assertSame($map->lookup($aNode), 'a');
        $this->assertSame($map->lookup($bNode), 'b');
        $this->assertSame($map->lookup($cNode), 'c');
        
        $map->insert(new Node(2, 2), 'b_');
        $map->insert(new Node(2, 3), 'c_');
        $this->assertSame($map->delete($aNode), 'a');
        $this->assertSame($map->delete($bNode), 'b_');
        $this->assertSame($map->delete($cNode), 'c_');
        $this->assertTrue($map->isEmpty());
        
        $map->insert($fNode, $eNode);
        $map->insert($eNode, $dNode);
        $map->insert($dNode, $cNode);
        $map->insert($cNode, $bNode);
        $map->insert($bNode, $aNode);
        $this->assertSamePath(array($aNode, $bNode, $cNode, $dNode, $eNode, $fNode), $map->lookupFrom($fNode));
        $this->assertSamePath(array($aNode, $bNode, $cNode, $dNode), $map->lookupFrom($dNode));
        
        $map->insert($bNode, $aNode);
        $map->insert($cNode, $bNode);
        $map->insert($dNode, $cNode);
        $map->insert($eNode, $dNode);
        $map->insert($fNode, $eNode);
        $this->assertSamePath(array($aNode, $bNode, $cNode, $dNode, $eNode, $fNode), $map->lookupFrom($fNode));
        $this->assertSamePath(array($aNode, $bNode, $cNode, $dNode), $map->lookupFrom($dNode));
        
        $map->insert($eNode, $fNode);
        $map->insert($fNode, $eNode);
        $this->assertSamePath(array($eNode, $fNode), $map->lookupFrom($fNode));
        $this->assertSamePath(array($fNode, $eNode), $map->lookupFrom($eNode));
        
        $map->insert($eNode, $eNode);
        $this->assertSamePath(array($eNode), $map->lookupFrom($eNode));
    }

    private function assertSamePath(array $a, array $b)
    {
        $aPath = new NodePath($a);
        $bPath = new NodePath($b);
        
        $this->assertSame($aPath->toString(), $bPath->toString());
    }
}