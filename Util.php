<?php

class Util
{

    /**
     * Calculate sigmoid(x)
     * @param float $x
     * @return float
     */
    public static function sigmoid($x)
    {
        return 1. / (1 + exp(-$x));
    }

    /**
     * Returns an element from the array with maximal value.
     * Compares the elements in the array with the given function $isLess.
     * @param array $arr
     * @param callable $isLess
     * @return mixed
     */
    public static function maxByFunc(array $arr, callable $isLess)
    {
        return self::cmpByFunc($arr, $isLess, True);
    }

    /**
     * Returns an element from the array with maximal $key(value).
     * @param array $arr
     * @param callable $key
     * @return mixed
     */
    public static function maxByKey(array $arr, callable $key)
    {
        return self::cmpByKey($arr, $key, True);
    }

    /**
     * Returns an element from the array with minimal value.
     * Compares the elements in the array with the given function $isLess.
     * @param array $arr
     * @param callable $isLess
     * @return mixed
     */
    public static function minByFunc(array $arr, callable $isLess)
    {
        return self::cmpByFunc($arr, $isLess, False);
    }

    /**
     * Returns an element from the array with minimal $key(value).
     * @param array $arr
     * @param callable $key
     * @return mixed
     */
    public static function minByKey(array $arr, callable $key)
    {
        return self::cmpByKey($arr, $key, False);
    }

    /**
     * @param array $arr
     * @param callable $isLess
     * @param $wantMax
     * @return mixed
     */
    private static function cmpByFunc(array $arr, callable $isLess, $wantMax)
    {
        assert(count($arr) > 0, "Array can't be empty");

        $ret = array_pop($arr);

        foreach ($arr as $value) {
            if ($isLess($value, $ret) ^ $wantMax)
                $ret = $value;
        }

        return $ret;
    }

    /**
     * @param array $arr
     * @param callable $key
     * @param $wantMax
     * @return mixed
     */
    private static function cmpByKey(array $arr, callable $key, $wantMax)
    {
        assert(count($arr) > 0, "Array can't be empty");

        $retVal = array_pop($arr);
        $retKey = $key($retVal);

        foreach ($arr as $v) {
            $k = $key($v);

            if (($k < $retKey) ^ $wantMax) {
                $retVal = $v;
                $retKey = $k;
            }
        }

        return $retVal;
    }

}