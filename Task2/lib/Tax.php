<?php
/**
 * Created by PhpStorm.
 * User: hovsep
 * Date: 04.02.19
 * Time: 0:15
 */

class Tax implements Calculable {

    /**
     * Tax percentage
     *
     * 1-100
     */
    private $tax;


    /**
     * Tax constructor.
     */
    public function __construct($tax)
    {
        if (empty($tax) || $tax > 100) {
            throw new \RuntimeException('Invalid tax value');
        }

        $this->tax = $tax;
    }

    public function calculate($base)
    {
        return $base * $this->tax / 100;
    }


}