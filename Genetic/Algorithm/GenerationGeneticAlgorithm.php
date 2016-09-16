<?php

namespace Genetic\Algorithm;


use Genetic\Chromosome\Chromosome;
use Genetic\Chromosome\ChromosomePopulation;

/**
 * While not done:
 *      create a new population NEW_POP
 *      copy $elitism best chromosomes from OLD_POP to NEW_POP
 *      While size(OLD_POP) < size(NEW_POP):
 *          parents <- choose(OLD_POP)
 *          child <- mutate(crossover(parent1, parent2))
 *          add child to NEW_POP
 *      NEW_POP <- OLD_POP
 */
class GenerationGeneticAlgorithm extends GeneticAlgorithm
{

    /** @var  int */
    private $elitism;

    public function __construct(
        ChromosomePopulation $population,
        $numberOfIterations,
        $elitism)
    {
        assert($population->getSize() > 1, 'Population must contain more than one chromosome.');
        parent::__construct($population, $numberOfIterations);
        $this->elitism = min(max($elitism, 0), $this->population->getSize());
    }

    public function runIteration()
    {

        $newPopulation = ChromosomePopulation::bestFromPopulation($this->population, $this->elitism);

        while ($newPopulation->getSize() < $this->population->getSize()) {

            // select parents
            $parents = $this->population->selectDiverse(2);
            /** @var Chromosome $p1 */
            $p1 = $parents[0]['chromosome'];
            /** @var Chromosome $p2 */
            $p2 = $parents[1]['chromosome'];

            // create child using crossover and mutate it
            $child = $this->population->crossover($p1, $p2);
            $this->population->mutate($child);

            $newPopulation->addChromosome($child);

        }

        $this->population = $newPopulation;
        $best = $this->population->getBest();
        $this->iteration++;

        return [
            'best' => $best,
            'done' => $this->iteration >= $this->numberOfIterations,
            'iteration' => $this->iteration
        ];
    }

}