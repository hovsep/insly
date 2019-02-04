<?php
/**
 * Created by PhpStorm.
 * User: hovsep
 * Date: 03.02.19
 * Time: 23:23
 */

class BasePrice implements Calculable, DayAndHourAware {

    const FRIDAY = 5;

    const BASIC_MULTIPLIER = 0.11;

    const CUSTOM_MULTIPLIER = 0.13;

    const CUSTOM_MULTIPLIER_START_HOUR = 15;

    const CUSTOM_MULTIPLIER_END_HOUR = 15;

    /**
     * 1-6 day ow week code (0 - Sunday)
     *
     * @see https://developer.mozilla.org/en/docs/Web/JavaScript/Reference/Global_Objects/Date/getDay
     */
    private $day = null;

    /**
     * 0-23 integer
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date/getHours
     */
    private $hour;

    public function setDayAndHour($day, $hour)
    {
        $this->day = (int) $day;
        $this->hour = (int) $hour;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMultiplier()
    {
        return ((self::FRIDAY == $this->day) && ($this->hour >= self::CUSTOM_MULTIPLIER_START_HOUR) && ($this->hour <= self::CUSTOM_MULTIPLIER_END_HOUR)) ? self::CUSTOM_MULTIPLIER : self::BASIC_MULTIPLIER;
    }



    public function calculate($base)
    {
        if (is_null($this->day) || is_null($this->hour)) {
            throw new \RuntimeException('Please set day and hour before calling calculate method');
        }

        return $base * $this->getMultiplier();
    }


}