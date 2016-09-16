<?php

namespace Implementation;


use Genetic\Chromosome\Chromosome;
use Genetic\GARunner;

class Test
{



    public function run()
    {
        // one parameter x
        // try to find solution to 4-(x+3)^2 is maximum


        /** @var Chromosome $chromosome
         * @return float
         */
        $err = function ($chromosome) {
            $x = $chromosome->getGene(0);
            return ($x + 3) * ($x + 3);
        };

        (new GARunner($err, 1))->run();
    }

}