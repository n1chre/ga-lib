<?php

namespace Genetic\Operator\Selection;

use Genetic\Chromosome\ChromosomePopulation;

interface Selection
{

    /**
     * Takes a population of chromosomes and returns a single chromosome.
     * @param ChromosomePopulation $population
     * @return array ['chromosome'  => chosen chromosome,
     *                'error'       => its error,
     *                'index'       => index in population]
     */
    public function select(ChromosomePopulation $population);

}