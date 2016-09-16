<?php

namespace Genetic\Chromosome;


use RandomGen;

/**
 * An implementation of Chromosome interface that contains genes
 * but doesn't know how to calculate it's error.
 * @package Genetic\Chromosome
 */
abstract class NumericChromosome implements Chromosome
{

    private static $DELTA = 1e-8;

    /** @var  array */
    protected $genes;

    /** @var  int */
    protected $n; // number of genes

    /**
     * Creates a new chromosome with $n genes all set to 0.0
     * @param int $n number od genes
     */
    public function __construct($n)
    {
        assert($n > 0, 'Number of genes must be positive');
        $this->n = $n;
        $this->genes = [];
        for ($i = 0; $i < $n; $i++) {
            $this->genes[] = 0.0;
        }
    }

    /**
     * Sets every gene to a random value from a normal distribution with average
     * set to $average and standard deviation set to $stddev.
     * @param float $average average
     * @param float $stddev standard deviation
     */
    public function randomInit($average, $stddev)
    {
        for ($i = 0; $i < $this->n; $i++) {
            $this->genes[$i] = RandomGen::randGenNormal($average, $stddev);
        }
    }

    public function getNumberOfGenes()
    {
        return $this->n;
    }

    public function getGene($index)
    {
        $this->checkIndex($index);
        return $this->genes[$index];
    }

    public function getAllGenes()
    {
        return $this->genes;
    }

    public function setGene($index, $value)
    {
        $this->checkIndex($index);
        $this->genes[$index] = $value;
    }

    public function swapGenes($i, $j)
    {
        $this->checkIndex($i);
        $this->checkIndex($j);
        $tmp = $this->genes[$i];
        $this->genes[$i] = $this->genes[$j];
        $this->genes[$j] = $tmp;
    }

    public function reversePart($lo, $hi)
    {
        while ($lo < $hi)
            $this->swapGenes($lo--, $hi--);
    }

    public function equals(Chromosome $other)
    {
        if ($this->n != $other->getNumberOfGenes())
            return false;

        for ($i = 0; $i < $this->n; $i++) {
            if ($this->getGene($i) != $other->getGene($i))
                return false;
        }

        return true;
    }

    public function toString()
    {
        return '[' . implode(', ', $this->genes) . ']';
    }

    /**
     * Checks if it is true that 0 <= $index < number_of_genes
     * @param int $index
     */
    private function checkIndex($index)
    {
        assert(
            0 <= $index && $index < $this->n,
            "Gene index[$index] out of bounds, have $this->n genes"
        );
    }

}