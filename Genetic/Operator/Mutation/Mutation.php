<?php

namespace Genetic\Operator\Mutation;

use Genetic\Chromosome\Chromosome;

interface Mutation
{

    /**
     * Performs an "in place" mutation of the given chromosome.
     * This means that it's supposed to modify the given chromosome.
     * @param Chromosome $c
     */
    public function mutate(Chromosome $c);

}