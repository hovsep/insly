<?php
/**
 * Created by PhpStorm.
 * User: hovsep
 * Date: 03.02.19
 * Time: 23:52
 */

interface DayAndHourAware {

    const FRIDAY = 5;

    public function setDayAndHour($day, $hour);

}