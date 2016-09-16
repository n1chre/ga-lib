<?php

class RandomGen
{

    /** @var float */
    private static $EPSILON = 1e-10;

    /** @var float */
    private static $TWO_PI = 2.0 * M_PI;

    /** @var  float */
    private static $z;

    /** @var  bool */
    private static $generate = false;

    /**
     * Return a number from a normal distribution with average $average and
     * standard deviation $stddev.
     * @param float $average
     * @param float $stddev
     * @return float
     */
    public static function randGenNormal($average, $stddev)
    {
        // box muller transform

        if (!self::$generate ^= true)
            return self::$z * $stddev + $average;

        do {
            $u1 = 1. * mt_rand() / mt_getrandmax();
            $u2 = 1. * mt_rand() / mt_getrandmax();
        } while ($u1 <= self::$EPSILON);

        $tmp = sqrt(-2 * log($u1));
        self::$z = $tmp * sin(self::$TWO_PI * $u2);

        return $tmp * cos(self::$TWO_PI * $u2) * $stddev + $average;
    }

    /**
     * Return a number from a uniform distribution on interval [$lo,$hi]
     * @param float $lo
     * @param float $hi
     * @return float
     */
    public static function randGenUniform($lo, $hi)
    {
        return 1. * mt_rand() / mt_getrandmax() * ($hi - $lo) + $lo;
    }

    /**
     * Return a random integer on interval [0,$hi>
     * @param int $hi
     * @return int
     */
    public static function randGenInt($hi)
    {
        return mt_rand(0, max(0, $hi - 1));
    }

    /**
     * Returns a random element chosen from an array.
     * @param array $arr
     * @return mixed
     */
    public static function randChoice(array $arr)
    {
        return $arr[self::randGenInt(count($arr))];
    }

}