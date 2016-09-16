<?php

namespace Genetic\Operator\Crossover;


use Genetic\Chromosome\Chromosome;
use RandomGen;

class BLXAlphaCrossover implements Crossover
{

    /** @var  float */
    private $alpha;

    public function __construct($alpha)
    {
        $this->alpha = $alpha;
    }

    public function crossover(Chromosome $c1, Chromosome $c2)
    {
        $n = $c1->getNumberOfGenes();
        assert($n == $c2->getNumberOfGenes(), 'Chromosomes must have same number of properties');
        $child = $c1->createDefaultChromosome();

        // stores a 1 on position (n-i) if c1 has gene i smaller than c2
        $minFirst = 0;

        for ($i = 0; $i < $n; $i++) {
            $minFirst <<= 1;
            $minFirst |= ($c1->getGene($i) < $c2->getGene($i) ? 1 : 0);
        }

        for ($i = $n - 1; $i >= 0; $i--) {

            $c1p = $c1->getGene($i);
            $c2p = $c2->getGene($i);

            $delta = 1. * abs($c1p - $c2p) * $this->alpha;

            if ($minFirst & 1) {  // c1.props.i <  c2.props.i
                $lo = $c1p;
                $hi = $c2p;
            } else {              // c1.props.i >= c2.props.i
                $lo = $c2p;
                $hi = $c1p;
            }

            $lo -= $delta;
            $hi += $delta;

            $child->setGene($i, RandomGen::randGenUniform($lo, $hi));
            $minFirst >>= 1;
        }

        return $child;
    }

    /**
     * @return float
     */
    public function getAlpha()
    {
        return $this->alpha;
    }

    /**
     * @param float $alpha
     */
    public function setAlpha($alpha)
    {
        $this->alpha = $alpha;
    }


}