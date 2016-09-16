<?php

namespace Genetic\Operator\Crossover;

use RandomGen;

class UniformCrossover extends GeneTraverseCrossover
{

    /**
     * Creates a crossover operator which averages parents.
     */
    public function __construct()
    {
        $func = function ($x, $y) {
            if (RandomGen::randGenUniform(0.0, 1.0) < 0.5)
                return $x;
            else
                return $y;
        };
        parent::__construct($func);
    }

}