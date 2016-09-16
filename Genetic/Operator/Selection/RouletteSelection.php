<?php

namespace Genetic\Operator\Selection;

use Genetic\Chromosome\ChromosomePopulation;
use RandomGen;

class RouletteSelection implements Selection
{

    public function select(ChromosomePopulation $population)
    {
        $size = $population->getSize();
        $totalFitness = 0;
        for ($i = 0; $i < $size; $i++) {
            $totalFitness += $this->fitness($population->getChromosomePair($i)['error']);
        }

        $target = RandomGen::randGenInt($totalFitness);
        $totalSoFar = 0.0;

        for ($i = 0; $i < $size; $i++) {
            $c = $population->getChromosomePair($i);
            $totalSoFar += $this->fitness($c['error']);
            if ($target < $totalSoFar) {
                return [
                    'chromosome' => $c['chromosome'],
                    'error' => $c['error'],
                    'index' => $i
                ];
            }
        }

        return [];
    }

    /**
     * Return fitness based on error. Higher error means lower fitness
     * @param $error
     * @return float
     */
    public function fitness($error)
    {
        return 1. / $error;
    }

}