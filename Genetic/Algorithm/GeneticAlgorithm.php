<?php

namespace Genetic\Algorithm;

use Genetic\Chromosome\Chromosome;
use Genetic\Chromosome\ChromosomePopulation;

abstract class GeneticAlgorithm
{

    /** @var  ChromosomePopulation */
    protected $population;

    /** @var  int */
    protected $iteration;

    /** @var  int */
    protected $numberOfIterations;

    /**
     * Creates a new genetic algorithm that is run over given $population $numberOfIterations times.
     * @param ChromosomePopulation $population
     * @param int $numberOfIterations
     */
    public function __construct(
        ChromosomePopulation $population,
        $numberOfIterations = 1000
    )
    {
        $this->population = $population;

        $this->iteration = 0;
        $this->numberOfIterations = $numberOfIterations;
    }


    /**
     * Runs one iteration of the algorithm.
     * @return array which contains three values
     *      'best'      => best chromosome after that iteration
     *      'done'      => did the algorithm finish
     *      'iteration' => what iteration was this
     */
    public abstract function runIteration();

    /**
     * Runs the algorithm for a given number of iterations.
     * If $outputEvery is a positive number, it will output some information
     * after that many iterations.
     * @param int $outputEvery
     * @return Chromosome
     */
    public function run($outputEvery = -1)
    {
        $best = null;

        while (1) {

            $res = $this->runIteration();
            if ($res['done']) break;

            /** @var Chromosome $best */
            $best = $res['best'];

            $iteration = $res['iteration'];

            if ($outputEvery > 0 && ($iteration % $outputEvery == 0)) {
                printf("Iteration [%5d]:\tbest= %s;\terror= %.10lf\n", $iteration, $best->toString(), $best->error());
            }
        }

        printf("Done, best = %s; error = %lf\n", $best->toString(), $best->error());

        return $best;
    }

}