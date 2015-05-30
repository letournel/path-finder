PathFinder - 
=========
[![Build Status](https://travis-ci.org/letournel/path-finder.svg?branch=master)](https://travis-ci.org/letournel/path-finder)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/letournel/path-finder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/letournel/path-finder/?branch=master)

PathFinder is a standalone library aiming to implement famous path and route finding algorithms in PHP to solve classical problems such as:
- **[SSP: Shortest path problem](http://en.wikipedia.org/wiki/Shortest_path_problem)**
- **[TSP: Travelling salesman problem](http://en.wikipedia.org/wiki/Travelling_salesman_problem)**

Features
--------

Available SSP solving algorithms:
- **[Dijkstra](http://en.wikipedia.org/wiki/Dijkstra%27s_algorithm)**
- **[FloydWarshall](http://en.wikipedia.org/wiki/Floyd%E2%80%93Warshall_algorithm)**
- **[AStar](http://en.wikipedia.org/wiki/A*_search_algorithm)**

Available TSP solving algorithms:
- **[NearestNeighbour](http://en.wikipedia.org/wiki/Nearest_neighbour_algorithm)**
- **[2Opt](http://en.wikipedia.org/wiki/2-opt)**
- **[3Opt](http://en.wikipedia.org/wiki/3-opt)**

Available distances:
- **[Chebyshev](http://en.wikipedia.org/wiki/Chebyshev_distance)**
- **[Euclidean](http://en.wikipedia.org/wiki/Euclidean_distance)**
- **[Manhattan](http://en.wikipedia.org/wiki/Manhattan_distance)**
- **Octile**
- **Zero**

Roadmap
-------

SSP solving algorithms:
* open to suggestions and contributions

TSP solving algorithms:
* [Christofides](http://en.wikipedia.org/wiki/Christofides_algorithm)
* [kOpt](http://en.wikipedia.org/wiki/k-opt)
* [LinKernighan](http://en.wikipedia.org/wiki/Lin%E2%80%93Kernighan_heuristic)
* open to suggestions and contributions


Main Classes
------------
- **Core\Heuristic**: A distance with a floating weight.
- **Core\Node**: A node entity used in NodeGrid, NodeGraph, NodeMap or NodePath which is basically a couple of coordinates (x, y) or indices (i,j)
- **Core\NodeGraph**: A [graph](http://en.wikipedia.org/wiki/Graph_(mathematics)) is a set of vertices connected by edges. Here, vertices are nodes and any couple of them can be connected by an edge with a floating value. By default, the graph is symmetric so the edge from vertex A to vertex B and vice versa have the same value.
- **Core\NodeGrid**: Simply a matrix of Nodes with coordinates (x, y) or indices (i,j) using the following pattern:
```
    .--------------> j (width) coord y
    | 1,1 1,2 1,3
    | 2,1 2,2 2,3
    | 3,1 ...
    |
    i (height) coord x
```
- **Core\NodeMap**: A map or dictionary which maps a Node (as key) to an object (as value) which can be a Node, boolean, ...
- **Core\NodePath**: A linked list of successive Nodes which forms a path

- **Converters\Grid\ASCIISyntax**: Allow converting map with a ascii syntax to NodeMap, NodePath, Node Objects back and forth

- **Algorithms\ShortestDistance\Dijkstra**: Compute shortest distance with Dijkstra algorithm
- **Algorithms\ShortestDistance\FloydWarshall**: Compute shortest distance with FloydWarshall algorithm

- **Algorithms\ShortestPath\AStar**: Compute shortest path with AStar algorithm
- **Algorithms\ShortestPath\Dijkstra**: Compute shortest path with Dijkstra algorithm

- **Algorithms\TravelingSalesman\NearestNeighbour**: Compute shortest tour with NearestNeighbour algorithm
- **Algorithms\TravelingSalesman\ThreeOpt**: Improve shortest tour with ThreeOpt algorithm
- **Algorithms\TravelingSalesman\TwoOpt**: Improve shortest tour with TwoOpt algorithm

- **Distances\Chebyshev**: Implementation of the Chebyshev distance between nodes A and B which is max(|dx|, |dy|)
- **Distances\Euclidean**: Implementation of the Euclidean distance between nodes A and B which is sqrt(|dx|^2 + |dy|^2)
- **Distances\Manhattan**: Implementation of the Manhattan distance between nodes A and B which is |dx| + |dy|
- **Distances\Octile** : Implementation of the Octile distance between nodes A and B which is (|dx| < |dy|) ? (sqrt(2) - 1) * |dx| + |dy|: (sqrt(2) - 1) * |dy| + |dx|
- **Distances\Zero** : Implementation of the null or zero distance between nodes A and B which is always 0


Examples
--------

ASCIISyntax for maps:
* Path: '.'
* Source: '>'
* Target: '<'
* Wall: 'X'

SSP solving:
```php
    TODO
```

Installation
------------
Use composer:
```json
{
    "require": {
        "Letournel/PathFinder" : "~1.0"
    }
}
```

Legal
-----
Letournel/PathFinder is Copyright(c) 2015 Letournel

Code released under the MIT license
