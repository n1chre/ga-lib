<?php

namespace Genetic\Operator\Mutation;


use Genetic\Chromosome\Chromosome;
use RandomGen;

/**
 * Centre Inverse Mutation
 * @package Genetic\Operator\Mutation
 */
class CIMMutation implements Mutation
{

    /**
     * The chromosome is divided into two sections. All genes in each section are copied
     * and then inversely placed in the same section of a child.
     * @param Chromosome $c
     */
    public function mutate(Chromosome $c)
    {
        $n = $c->getNumberOfGenes();
        $index = RandomGen::randGenInt($n);

        if ($index > 0)
            $c->reversePart(0, $index);
        if ($index + 1 < $n - 2)
            $c->reversePart($index + 1, $n - 1);
    }

}