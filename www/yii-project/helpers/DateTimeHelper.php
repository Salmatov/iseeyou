<?php

namespace app\helpers;

class DateTimeHelper
{
    public static function getMonthDifference(string $startDate, string $endDate): int
    {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);

        $startYear = date('Y', $startTimestamp);
        $startMonth = date('n', $startTimestamp);
        $endYear = date('Y', $endTimestamp);
        $endMonth = date('n', $endTimestamp);

        $monthDiff = (($endYear - $startYear) * 12) + ($endMonth - $startMonth);
        return $monthDiff;
    }
}