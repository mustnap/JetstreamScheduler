<?php

namespace App\Services;

// Declare a class
class PriorityQueue extends \SplPriorityQueue
{

    // Compare function to compare priority
    // queue elements
    public function compare($p1,  $p2): int
    {
        if ($p1 === $p2) return 0;
        return $p1 < $p2 ? -1 : 1;
    }
}
