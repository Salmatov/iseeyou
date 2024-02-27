<?php

namespace app\service;


use DateTime;

class TimeService
{

    public static function setDateTime($date):DateTime|array
    {
        $dateObject = DateTime::createFromFormat("d-m-Y H:i:s", $date);

        if ($dateObject === false) {
            throw new \Exception('Некорректный формат даты.', 400);
        }
        return $dateObject;
    }

    public static function formatDateTimeForDatabase(DateTime $date):string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function formatDateTimeForView(DateTime $date):string
    {
        return $date->format('d-m-Y H:i:s');
    }

}