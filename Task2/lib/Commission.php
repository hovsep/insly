<?php
/**
 * Created by PhpStorm.
 * User: hovsep
 * Date: 04.02.19
 * Time: 0:11
 */

class Commission implements Calculable {

    const MULTIPLIER = 0.17;

    public function calculate($base)
    {
        return $base * self::MULTIPLIER;
    }


}