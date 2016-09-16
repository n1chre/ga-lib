<?php

namespace Genetic\Operator\Mutation;

use Genetic\Chromosome\Chromosome;
use RandomGen;


/**
 * Adds random gaussian noise to each gene.
 * @package Genetic\Operator\Mutation
 */
class GaussMutation implements Mutation
{

    /** @var  float */
    private $mutationProbability;

    /** @var  float */
    private $mutationScale;

    public function __construct($mutationProbability = 0.2, $mutationScale = 2.4)
    {
        $this->mutationProbability = $mutationProbability;
        $this->mutationScale = $mutationScale;
    }

    public function mutate(Chromosome $c)
    {
        $n = $c->getNumberOfGenes();
        for ($i = 0; $i < $n; $i++) {

            if (RandomGen::randGenUniform(0., 1.) > $this->mutationProbability)
                continue;

            $noise = RandomGen::randGenNormal(0, $this->mutationScale);
            $c->setGene($i, $c->getGene($i) + $noise);

        }
    }

    /**
     * @return float
     */
    public function getMutationScale()
    {
        return $this->mutationScale;
    }

    /**
     * @param float $mutationScale
     */
    public function setMutationScale($mutationScale)
    {
        $this->mutationScale = $mutationScale;
    }

    /**
     * @return float
     */
    public function getMutationProbability()
    {
        return $this->mutationProbability;
    }

    /**
     * @param float $mutationProbability
     */
    public function setMutationProbability($mutationProbability)
    {
        $this->mutationProbability = $mutationProbability;
    }


}