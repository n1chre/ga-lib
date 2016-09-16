<?php

namespace Genetic\Operator\Selection;

use Genetic\Chromosome\ChromosomePopulation;
use RandomGen;

class TournamentSelection implements Selection
{

    /** @var  int */
    private $k;

    public function __construct($k = 10)
    {
        $this->k = $k;
    }

    public function select(ChromosomePopulation $population)
    {
        $size = $population->getSize();
        $tournamentSize = min($this->k, $size);
        $best = [
            'chromosome' => null,
            'error' => PHP_INT_MAX,
            'index' => -1
        ];
        $chosen = 0;

        while ($chosen++ < $tournamentSize) {
            $idx = RandomGen::randGenInt($size);
            $random = $population->getChromosomePair($idx);
            if ($random['error'] < $best['error']) {
                $best = [
                    'chromosome' => $random['chromosome'],
                    'error' => $random['error'],
                    'index' => $idx
                ];
            }
        }

        return $best;
    }

}