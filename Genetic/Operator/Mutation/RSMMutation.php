<?php

namespace Genetic\Operator\Mutation;


use Genetic\Chromosome\Chromosome;
use RandomGen;

/**
 * Reverse Sequence Mutation
 * @package Genetic\Operator\Mutation
 */
class RSMMutation implements Mutation
{

    public function mutate(Chromosome $c)
    {
        $n = $c->getNumberOfGenes();

        $hi = RandomGen::randGenInt($n);
        $lo = RandomGen::randGenInt($hi);

        $c->reversePart($lo,$hi);
    }

}