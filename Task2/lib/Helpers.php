<?php
/**
 * Created by PhpStorm.
 * User: hovsep
 * Date: 04.02.19
 * Time: 2:04
 */

class Helpers
{

    /**
     * Prints formatted price number
     *
     * @param $number
     * @param int $precision
     */
    public static function nf($number, $precision = 2)
    {
        echo number_format(round($number, $precision), $precision, '.', ' ');
    }
}