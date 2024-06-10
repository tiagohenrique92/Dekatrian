<?php

declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Converters;

use DateTime;
use TiagoHenrique92\Dekatrian\Entities\GregorianDate;

class GregorianConverter implements Converter
{
    private int $dekatrianYear;
    private int $dekatrianMonth;
    private int $dekatrianDay;
    private int $gregorianDayOfMonth;
    private int $gregorianDayOfYear;
    private int $gregorianNumericMonth;
    private int $gregorianNumericWeekday;
    private string $gregorianTextMonth;
    private string $gregorianTextWeekday;
    private int $gregorianYear;
    private bool $leapYear;

    /**
     * @param string $receivedDate
     * @param string|null $timezone
     * @return GregorianDate
     */
    public function convert(string $receivedDate, string $timezone = null): GregorianDate
    {
        $initialTimezone = date_default_timezone_get();
        date_default_timezone_set($timezone ?? $initialTimezone);

        $this->handler($receivedDate);

        date_default_timezone_set($initialTimezone);
        return new GregorianDate(
            year: $this->gregorianYear,
            dayOfYear: $this->gregorianDayOfYear,
            dayOfMonth: $this->gregorianDayOfMonth,
            leapYear: $this->leapYear,
            numericMonth: $this->gregorianNumericMonth,
            textMonth: $this->gregorianTextMonth,
            textWeekday: $this->gregorianTextWeekday,
            numericWeekday: $this->gregorianNumericWeekday
        );
    }

    private function handler(string $receivedDate): void
    {
        $this->extractDekatrianDateInfo($receivedDate);
        $this->setGregorianDate();
    }

    private function extractDekatrianDateInfo(string $dekatrianDate): void
    {
        $dekatrianDateArray = explode('-', $dekatrianDate);
        $this->dekatrianYear = (int) $dekatrianDateArray[0];
        $this->dekatrianMonth = (int) $dekatrianDateArray[1];
        $this->dekatrianDay = (int) $dekatrianDateArray[2];
    }

    private function isLeapYear(): bool
    {
        $lastDayOfYear = "$this->dekatrianYear-12-31";
        return (bool) date('L', strtotime($lastDayOfYear));
    }

    private function setGregorianDate(): void
    {
        $leapYear = $this->isLeapYear();
        $diffDays = $leapYear ? 2 : 1;

        $key = "$this->dekatrianMonth-$this->dekatrianDay-$diffDays";
        $dayOfYear = match ($key) {
            "0-1-1", "0-1-2" => 0,
            "0-2-2" => 1,
            default => (($this->dekatrianMonth - 1) * 28) + $this->dekatrianDay + $diffDays - 1
        };

        $date = DateTime::createFromFormat(
            'Y z' ,
            "$this->dekatrianYear $dayOfYear"
        )->format('Y-m-d');

        $gregorianDateInfo = getdate(strtotime($date));

        $this->leapYear = $leapYear;
        $this->gregorianYear = $gregorianDateInfo['year'];
        $this->gregorianDayOfYear = $gregorianDateInfo['yday'];
        $this->gregorianDayOfMonth = $gregorianDateInfo['mday'];
        $this->gregorianNumericMonth = $gregorianDateInfo['mon'];
        $this->gregorianNumericWeekday = $gregorianDateInfo['wday'];
        $this->gregorianTextMonth = $gregorianDateInfo['month'];
        $this->gregorianTextWeekday = $gregorianDateInfo['weekday'];
    }
}
