<?php

namespace Genetic;

use Genetic\Algorithm\GenerationGeneticAlgorithm;
use Genetic\Algorithm\GeneticAlgorithm;
use Genetic\Chromosome\ChromosomePopulation;
use Genetic\Chromosome\ErrorChromosome;
use Genetic\Operator\Crossover\ArithmeticAverageCrossover;
use Genetic\Operator\Mutation\GaussMutation;
use Genetic\Operator\Selection\RouletteSelection;

class GARunner
{

    /** @var  GeneticAlgorithm */
    private $ga;

    /** @var  int */
    private $outputEvery;

    public function __construct(
        callable $error,
        $numberOfGenes,
        $selection = null,
        $crossover = null,
        $mutation = null,
        $populationSize = 25,
        $elitism = 5,
        $cAverage = 0,
        $cStddev = 2.4,
        $numIterations = 10000,
        $outputEvery = 100)
    {

        // create population
        $pop = new ChromosomePopulation(
            $selection ?: new RouletteSelection(),
            $crossover ?: new ArithmeticAverageCrossover(),
            $mutation ?: new GaussMutation()
        );
        while ($populationSize-- > 0) {
            $c = new ErrorChromosome($numberOfGenes, $error);
            $c->randomInit($cAverage, $cStddev);
            $pop->addChromosome($c);
        }

        $this->ga = new GenerationGeneticAlgorithm($pop, $numIterations, $elitism);
        $this->outputEvery = $outputEvery;
    }

    public function run()
    {
        $this->ga->run($this->outputEvery);
    }

}