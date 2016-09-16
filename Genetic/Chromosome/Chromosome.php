<?php

namespace Genetic\Chromosome;

/**
 * Interface Chromosome
 * Contains basic function that chromosome must have
 * @package Genetic\Chromosome
 */
interface Chromosome
{

    /**
     * Creates a default chromosome.
     * @return Chromosome
     */
    function createDefaultChromosome();

    /**
     * @return float error that this chromosome produces
     */
    function error();

    /**
     * @param Chromosome $other
     * @return bool returns true if both chromosomes are same
     */
    function equals(Chromosome $other);

    /**
     * @return int number of genes that this chromosome has
     */
    public function getNumberOfGenes();

    /**
     * @param int $index index of wanted gene
     * @return mixed gene
     */
    public function getGene($index);

    /**
     * @return array genes
     */
    public function getAllGenes();

    /**
     * @param int $index index of gene you want to change
     * @param mixed $value value to set
     */
    public function setGene($index, $value);

    /**
     * Swap genes at positions $i and $j
     * @param int $i index
     * @param int $j index
     */
    public function swapGenes($i, $j);

    /**
     * Take genes from index $lo to $hi and reverse them.
     * Interval is [$lo, $hi]
     * Copy genes in that section and then inversely place them in the same section.
     * @param int $lo low index
     * @param int $hi high index
     */
    public function reversePart($lo,$hi);

    /**
     * @return string representation
     */
    function toString();

}