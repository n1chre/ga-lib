<?php

namespace Genetic\Operator\Crossover;

use Genetic\Chromosome\Chromosome;

class GeneTraverseCrossover implements Crossover
{

    /** @var  callable */
    private $func;

    /**
     * Creates a new crossover operator which goes through parents chromosomes and
     * creates a child with child.gene(i) = $func(p1.gene(i), p2.gene(i))
     * @param callable $func
     */
    public function __construct(callable $func)
    {
        $this->func = $func;
    }

    public function crossover(Chromosome $c1, Chromosome $c2)
    {
        $n = $c1->getNumberOfGenes();
        assert($n == $c2->getNumberOfGenes(), 'Chromosomes must have same number of genes');

        $f = $this->func;
        $child = $c1->createDefaultChromosome();

        for ($i = 0; $i < $n; $i++) {
            $child->setGene($i, $f($c1->getGene($i), $c2->getGene($i)));
        }

        return $child;
    }

}