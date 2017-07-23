PathFinder - The best route is the shortest
===========================================
[![Latest Stable Version](https://poser.pugx.org/letournel/path-finder/v/stable.png)](https://packagist.org/packages/letournel/path-finder)
[![Build Status](https://travis-ci.org/letournel/path-finder.svg?branch=master)](https://travis-ci.org/letournel/path-finder)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/letournel/path-finder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/letournel/path-finder/?branch=master)

PathFinder is a standalone library aiming to implement famous path and route finding algorithms in PHP to solve classical problems such as:
- **[SSP: Shortest path problem](http://en.wikipedia.org/wiki/Shortest_path_problem)**
- **[TSP: Travelling salesman problem](http://en.wikipedia.org/wiki/Travelling_salesman_problem)**

Features
--------

- Distances:
[Chebyshev](http://en.wikipedia.org/wiki/Chebyshev_distance),
[Euclidean](http://en.wikipedia.org/wiki/Euclidean_distance),
[Manhattan](http://en.wikipedia.org/wiki/Manhattan_distance),
Octile,
Zero

- SSP solving algorithms:
[AStar](http://en.wikipedia.org/wiki/A*_search_algorithm),
[Dijkstra](http://en.wikipedia.org/wiki/Dijkstra%27s_algorithm),
[FloydWarshall](http://en.wikipedia.org/wiki/Floyd%E2%80%93Warshall_algorithm)

- TSP solving algorithms:
[NearestNeighbour](http://en.wikipedia.org/wiki/Nearest_neighbour_algorithm),
[2Opt](http://en.wikipedia.org/wiki/2-opt),
[3Opt](http://en.wikipedia.org/wiki/3-opt)

Roadmap
-------

- New SSP solving algorithms:
[Kruskal](http://en.wikipedia.org/wiki/Kruskal%27s_algorithm)
[MooreBellmanFord](http://en.wikipedia.org/wiki/Bellman%E2%80%93Ford_algorithm)
[Prim](http://en.wikipedia.org/wiki/Prim%27s_algorithm)
or others

- New TSP solving algorithms:
[Christofides](http://en.wikipedia.org/wiki/Christofides_algorithm),
[kOpt](http://en.wikipedia.org/wiki/k-opt),
[LinKernighan](http://en.wikipedia.org/wiki/Lin%E2%80%93Kernighan_heuristic)
or others

- Speed optimisations

- Open to suggestions and contributions

Classes
-------

#### Core Classes
- **Heuristic**: A distance with a floating weight.
- **Node**: A node entity used in NodeGrid, NodeGraph, NodeMap or NodePath which is basically a couple of coordinates (x, y) or indices (i,j)
- **NodeGraph**: A [graph](http://en.wikipedia.org/wiki/Graph_(mathematics)) is a set of vertices connected by edges. Here, vertices are nodes and any couple of them can be connected by an edge with a floating value. By default, the graph is symmetric so the edge from vertex A to vertex B and vice versa have the same value.
- **NodeGrid**: Simply a matrix of Nodes with coordinates (x, y) or indices (i,j) using the following pattern:
```
    .--------------> j (width) coord y
    | 1,1 1,2 1,3
    | 2,1 2,2 2,3
    | 3,1 ...
    |
    i (height) coord x
```
- **NodeMap**: A map or dictionary which maps a Node (as key) to an object (as value) which can be a Node, boolean, ...
- **NodePath**: A linked list of successive Nodes which forms a path

#### Algorithms Classes
- **ShortestDistance\Dijkstra**: Compute shortest distance with Dijkstra algorithm
- **ShortestDistance\FloydWarshall**: Compute shortest distance with FloydWarshall algorithm
- **ShortestPath\AStar**: Compute shortest path with AStar algorithm
- **ShortestPath\Dijkstra**: Compute shortest path with Dijkstra algorithm
- **TravelingSalesman\NearestNeighbour**: Compute shortest tour with NearestNeighbour algorithm
- **TravelingSalesman\ThreeOpt**: Improve shortest tour with ThreeOpt algorithm
- **TravelingSalesman\TwoOpt**: Improve shortest tour with TwoOpt algorithm

#### Converters Classes
- **Grid\ASCIISyntax**: Allow converting map with an ASCII syntax to NodeMap, NodePath, Node Objects back and forth

#### Distances Classes
- **Chebyshev**: Compute the Chebyshev distance between two nodes which is max(|dx|, |dy|)
- **Euclidean**: Compute the Euclidean distance between two nodes which is sqrt(|dx|^2 + |dy|^2)
- **Manhattan**: Compute the Manhattan distance between two nodes which is |dx| + |dy|
- **Octile** : Compute the Octile distance between two nodes which is (|dx| < |dy|) ? (sqrt(2) - 1) * |dx| + |dy|: (sqrt(2) - 1) * |dy| + |dx|
- **Zero** : Compute the null or zero distance between two nodes A and B which is always 0


Examples
--------

ASCIISyntax for maps:
* Path: '.'
* Source: '>'
* Target: '<'
* Wall: 'X'

SSP solving:
```php
    require __DIR__ . '/vendor/autoload.php';
    
    use Letournel\PathFinder\Algorithms;
    use Letournel\PathFinder\Converters\Grid\ASCIISyntax;
    use Letournel\PathFinder\Core;
    use Letournel\PathFinder\Distances;
    
    function solve($map, $algorithm)
    {
        $converter = new ASCIISyntax();
        $grid = $converter->convertToGrid($map);
        $matrix = $converter->convertToMatrix($map);
        $source = $converter->findAndCreateNode($matrix, ASCIISyntax::IN);
        $target = $converter->findAndCreateNode($matrix, ASCIISyntax::OUT);
        
        $algorithm->setGrid($grid);
        $starttime = microtime(true);
        $path = $algorithm->computePath($source, $target);
        $endtime = microtime(true);
        
        if($path instanceof Core\NodePath)
        {
            echo "Path found in " . floor(($endtime - $starttime) * 1000) . " ms\n";
            echo $converter->convertToSyntaxWithPath($grid, $path);
        }
        else
        {
            echo "No path found\n";
        }
    }
    
    $map =
        '                ' . "\n" .
        '.XXXXXX XXXXXXXX' . "\n" .
        ' X   XX<X  X    ' . "\n" .
        ' X X  XXX X   X ' . "\n" .
        '   X           >' . "\n" ;
    
    $distance = new Distances\Euclidean();
    $heuristic = new Core\Heuristic(new Distances\Euclidean(), 1);
    
    echo "Solving SSP with AStar:\n";
    solve($map, new Algorithms\ShortestPath\AStar($distance, $heuristic));
    echo "\n\n\n";
    
    echo "Solving SSP with Dijkstra:\n";
    solve($map, new Algorithms\ShortestPath\Dijkstra($distance));
    echo "\n\n\n";
```

Installation
------------
Use composer:
```json
{
    "require": {
        "letournel/path-finder" : "~1.0"
    }
}
```

Legal
-----
Letournel/PathFinder is Copyright(c) 2015 Letournel

Code released under the MIT license
