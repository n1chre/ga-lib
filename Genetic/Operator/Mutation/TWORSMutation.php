<?php

namespace Genetic\Operator\Mutation;

use Genetic\Chromosome\Chromosome;
use RandomGen;

class TWORSMutation implements Mutation
{

    /**
     * TWORS mutation allows the exchange of position of two genes randomly chosen.
     * @param Chromosome $c
     */
    public function mutate(Chromosome $c)
    {
        $n = $c->getNumberOfGenes();

        $i = RandomGen::randGenInt($n);
        $j = RandomGen::randGenInt($n);

        $c->swapGenes($i, $j);
    }

}