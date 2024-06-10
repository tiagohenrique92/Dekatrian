<?php
declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Converters;

use TiagoHenrique92\Dekatrian\Entities\BaseDateEntity;
use DateTime;

class GregorianConverter extends AbstractConverter
{
    private int $dekatrianYear;
    private int $dekatrianMonth;
    private int $dekatrianDay;

    /**
     * @param string $receivedDate
     * @param string|null $timezone
     * @return BaseDateEntity
     */
    public function convert(string $receivedDate, string $timezone = null): BaseDateEntity
    {
        $initialTimezone = date_default_timezone_get();
        date_default_timezone_set($timezone ?? $initialTimezone);

        $this->handler($receivedDate);

        date_default_timezone_set($initialTimezone);
        return $this->baseDateEntity;
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
        $lastDayOfYear = "{$this->dekatrianYear}-12-31";
        return (bool) date('L', strtotime($lastDayOfYear));
    }

    private function setGregorianDate(): void
    {
        $leapYear = $this->isLeapYear();
        $diffDays = $leapYear ? 2 : 1;
        $dekatrianDay = $this->dekatrianDay === 99 ? -1 : $this->dekatrianDay;
        $dayOfYear = (($this->dekatrianMonth - 1) * 28) + $dekatrianDay + $diffDays - 1;

        $date = DateTime::createFromFormat(
            'Y z' ,
            "{$this->dekatrianYear} {$dayOfYear}"
        )->format('Y-m-d');

        $gregorianDateInfo = getdate(strtotime($date));

        $this->baseDateEntity->setLeapYear($leapYear);
        $this->baseDateEntity->setYear($gregorianDateInfo['year']);
        $this->baseDateEntity->setDayOfYear($gregorianDateInfo['yday']);
        $this->baseDateEntity->setDayOfMonth($gregorianDateInfo['mday']);
        $this->baseDateEntity->setNumericMonth($gregorianDateInfo['mon']);
        $this->baseDateEntity->setNumericWeekday($gregorianDateInfo['wday']);
        $this->baseDateEntity->setTextMonth($gregorianDateInfo['month']);
        $this->baseDateEntity->setTextWeekday($gregorianDateInfo['weekday']);
    }
}