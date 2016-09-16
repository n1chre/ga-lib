<?php

namespace Genetic\Operator\Crossover;

use Genetic\Chromosome\Chromosome;

interface Crossover
{

    /**
     * Performs a crossover on the two given chromosomes.
     * @param Chromosome $c1
     * @param Chromosome $c2
     * @return Chromosome
     */
    public function crossover(Chromosome $c1, Chromosome $c2);

}