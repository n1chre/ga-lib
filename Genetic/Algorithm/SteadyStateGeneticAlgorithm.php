<?php

namespace Genetic\Algorithm;

/**
 * Repeat while not done:
 *      choose three chromosomes at random
 *      child = crossover two better + mutate
 *      remove the worst chromosome of the chosen three and replace it with child if child is not worse
 */
class EliminationGeneticAlgorithm extends GeneticAlgorithm
{

    public function runIteration()
    {
        $parents = $this->population->selectDiverse(3);

        $child = $this->population->crossover(
            $parents[0]['chromosome'],
            $parents[1]['chromosome']
        );
        $this->population->mutate($child);

        if ($child->error() < $parents[2]['error']) {
            $this->population->replaceChromosome(
                $parents[2]['index'],
                $child
            );
        }

        $best = $this->population->getBest();
        $this->iteration++;

        return [
            'best' => $best,
            'done' => $this->iteration >= $this->numberOfIterations,
            'iteration' => $this->iteration
        ];
    }
}