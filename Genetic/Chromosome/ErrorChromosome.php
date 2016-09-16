<?php

namespace Genetic\Chromosome;


class ErrorChromosome extends NumericChromosome
{

    /** @var  callable */
    private $errorFunction;

    /**
     * Creates a new chromosome with $n genes all set to a random value
     * from a normal distribution with average set to $average and
     * standard deviation set to $stddev. Also sets the error function that
     * is used for this chromosome (same can be accomplished by extending the
     * StdChromosome class and implementing the error function).
     * @param int $n number of genes
     * @param callable $errorFunction
     */
    public function __construct($n, $errorFunction)
    {
        parent::__construct($n);
        $this->errorFunction = $errorFunction;
    }

    public function createDefaultChromosome()
    {
        return new ErrorChromosome($this->n, $this->errorFunction);
    }

    public function error()
    {
        // TODO write this cleaner
        $f = $this->errorFunction;
        return $f($this);
    }

}