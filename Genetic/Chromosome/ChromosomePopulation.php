<?php

namespace Genetic\Chromosome;

use Genetic\Operator\Crossover\Crossover;
use Genetic\Operator\Mutation\Mutation;
use Genetic\Operator\Selection\Selection;
use RandomGen;
use Util;

class ChromosomePopulation
{

    /** @var  array */
    private $chromosomes;

    /** @var  Selection */
    private $selection;

    /** @var  Crossover */
    private $crossover;

    /** @var  Mutation */
    private $mutation;

    /**
     * Creates an empty chromosome population
     * @param Selection $selection selection method that is used
     * @param Crossover $crossover crossover method that is used
     * @param Mutation $mutation mutation method that is used
     */
    public function __construct($selection, $crossover, $mutation)
    {
        $this->chromosomes = [];
        $this->selection = $selection;
        $this->crossover = $crossover;
        $this->mutation = $mutation;
    }

    /**
     * Creates a new population using $keep best chromosomes from the $old population.
     * @param ChromosomePopulation $old old population
     * @param int $keep number of chromosomes to keep
     * @return ChromosomePopulation new population
     */
    public static function bestFromPopulation(ChromosomePopulation $old, $keep)
    {
        $keep = min(max(0, $keep), $old->getSize());

        $new = new ChromosomePopulation(
            $old->selection,
            $old->crossover,
            $old->mutation
        );
        $new->chromosomes = $old->chromosomes;

        // take only $keep best ones
        usort($new->chromosomes, [$new, "chromosome_cmp"]);
        $new->chromosomes = array_slice($new->chromosomes, 0, $keep);

        return $new;
    }

    /**
     * Select a chromosome from this population.
     * @return array [chromosome, error, index]
     */
    public function select()
    {
        return $this->selection->select($this);
    }

    /**
     * Select $k different chromosomes from this population.
     * They will be sorted based on their error in ascending order.
     * @param int $k
     * @return array
     */
    public function selectDiverse($k)
    {
        if ($k <= 0) return [];
        $size = $this->getSize();
        $k = min($k, $size);

        $indexArray = [];
        $ret = [];

        while ($k-- > 0) {

            do {
                $idx = RandomGen::randGenInt($size);
            } while (in_array($idx, $indexArray));
            $indexArray[] = $idx;

            $ch = $this->chromosomes[$idx];

            $ret[] = [
                'chromosome' => $ch['chromosome'],
                'error' => $ch['error'],
                'index' => $idx
            ];

        }

        // sort based on error
        usort($ret, [$this, "chromosome_cmp"]);

        return $ret;
    }

    /**
     * Performs a crossover on two given chromosomes
     * @param Chromosome $c1
     * @param Chromosome $c2
     * @return Chromosome
     */
    public function crossover(Chromosome $c1, Chromosome $c2)
    {
        return $this->crossover->crossover($c1, $c2);
    }

    /**
     * Adds mutations to the given chromosome
     * @param Chromosome $c
     */
    public function mutate(Chromosome $c)
    {
        $this->mutation->mutate($c);
    }

    /**
     * Returns the best chromosome in this population.
     * @return Chromosome best one in the population
     */
    public function getBest()
    {
        return Util::minByKey(
            $this->chromosomes,
            function ($chPair) {
                return $chPair['error'];
            }
        )['chromosome'];
    }

    /**
     * Adds the given chromosome to this population
     * @param Chromosome $c
     */
    public function addChromosome(Chromosome $c)
    {
        $this->chromosomes[] = [
            'chromosome' => $c,
            'error' => $c->error()
        ];
    }

    /**
     * Replace a chromosome at given index with new chromosome
     * @param int $index
     * @param Chromosome $chromosome
     */
    public function replaceChromosome($index, Chromosome $chromosome)
    {
        assert(0 <= $index && $index < $this->getSize(), 'Index out of bounds');
        $this->chromosomes[$index] = [
            'chromosome' => $chromosome,
            'error' => $chromosome->error()
        ];
    }

    /**
     * Returns an array containing chromosome and it's error
     * @param int $index chromosomes index
     * @return array
     */
    public function getChromosomePair($index)
    {
        assert(0 <= $index && $index < $this->getSize(), 'Index out of bounds');
        return $this->chromosomes[$index];
    }

    /**
     * @return int population size
     */
    public function getSize()
    {
        return count($this->chromosomes);
    }

    /**
     * Compares chromosomes based on their error
     * @param $c1 [chromosome1, error1]
     * @param $c2 [chromosome2, error2]
     * @return int comparison result
     */
    private static function chromosome_cmp($c1, $c2)
    {
        // every argument is an array [chromosome c, c->error]
        $c1e = $c1['error'];
        $c2e = $c2['error'];

        if ($c1e < $c2e)
            return -1;
        if ($c1e > $c2e)
            return 1;
        return 0;

    }

}