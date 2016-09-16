<?php

namespace Genetic\Operator\Crossover;

class ArithmeticAverageCrossover extends GeneTraverseCrossover
{

    /**
     * Creates a crossover operator which averages parents.
     */
    public function __construct()
    {
        $func = function ($x, $y) {
            return ($x + $y) / 2.0;
        };
        parent::__construct($func);
    }


}