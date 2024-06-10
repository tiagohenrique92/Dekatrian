<?php

declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Converters;

use TiagoHenrique92\Dekatrian\Entities\DekatrianDate;
use TiagoHenrique92\Dekatrian\Enums\DekatrianMonthEnum;
use TiagoHenrique92\Dekatrian\Enums\DekatrianSpecialDayEnum;
use TiagoHenrique92\Dekatrian\Enums\GregorianWeekdayEnum;
use TiagoHenrique92\Dekatrian\Exceptions\DekatrianMonthNotFoundException;
use TiagoHenrique92\Dekatrian\Exceptions\DekatrianWeekdayNotFoundException;
use TiagoHenrique92\Dekatrian\Exceptions\GregorianWeekdayNotFoundException;

class DekatrianConverter implements Converter
{
    private int $dekatrianDayOfMonth;
    private int $dekatrianDayOfYear;
    private int $dekatrianNumericMonth;
    private int $dekatrianNumericWeekday;
    private string $dekatrianTextMonth;
    private string $dekatrianTextWeekday;
    private int $dekatrianYear;
    private array $gregorianDateInfo;
    private int $gregorianTimestamp;
    private int $gregorianYear;
    private bool $leapYear;

    /**
     * @param string $receivedDate
     * @param string|null $timezone
     * @return DekatrianDate
     * @throws DekatrianMonthNotFoundException
     * @throws DekatrianWeekdayNotFoundException
     * @throws GregorianWeekdayNotFoundException
     */
    public function convert(string $receivedDate, string $timezone = null): DekatrianDate
    {
        $initialTimezone = date_default_timezone_get();
        date_default_timezone_set($timezone ?? $initialTimezone);

        $this->handler($receivedDate);

        date_default_timezone_set($initialTimezone);
        return new DekatrianDate(
            year: $this->dekatrianYear,
            dayOfYear: $this->dekatrianDayOfYear,
            dayOfMonth: $this->dekatrianDayOfMonth,
            leapYear: $this->leapYear,
            numericMonth: $this->dekatrianNumericMonth,
            textMonth: $this->dekatrianTextMonth,
            textWeekday: $this->dekatrianTextWeekday,
            numericWeekday: $this->dekatrianNumericWeekday
        );
    }

    /**
     * @param string $gregorianDate
     * @throws DekatrianMonthNotFoundException
     * @throws DekatrianWeekdayNotFoundException
     * @throws GregorianWeekdayNotFoundException
     */
    private function handler(string $gregorianDate)
    {
        $this->extractGregorianDateInfo($gregorianDate);
        $this->setDekatrianLeapYear();
        $this->setDekatrianYear();
        $this->setDekatrianYearDay();
        $this->setDekatrianMonth();
        $this->setDekatrianDayOfMonth();
        $this->setDekatrianWeekday();
    }

    private function extractGregorianDateInfo(string $gregorianDate): void
    {
        $this->gregorianTimestamp = strtotime($gregorianDate);
        $this->gregorianDateInfo = getdate($this->gregorianTimestamp);
        $this->gregorianYear = $this->gregorianDateInfo['year'];
    }

    private function getGregorianYearDay(): int
    {
        return $this->gregorianDateInfo['yday'];
    }

    /**
     * @param int $numericWeekday
     * @return string
     * @throws DekatrianWeekdayNotFoundException
     * @throws GregorianWeekdayNotFoundException
     */
    private function getDekatrianTextWeekday(int $numericWeekday): string
    {
        $dekatrianWeekdays = $this->getDekatrianWeekdays();

        if (isset($dekatrianWeekdays[$numericWeekday])) {
            return $dekatrianWeekdays[$numericWeekday];
        }

        throw new DekatrianWeekdayNotFoundException();
    }

    private function setDekatrianLeapYear(): void
    {
        $this->leapYear = (bool) date('L', $this->gregorianTimestamp);
    }

    /**
     * @throws DekatrianMonthNotFoundException
     */
    private function setDekatrianMonth(): void
    {
        $this->dekatrianNumericMonth = match($this->dekatrianDayOfYear < 0) {
            true => 0,
            false => intval($this->dekatrianDayOfYear / 28) + 1
        };
        $this->dekatrianTextMonth = DekatrianMonthEnum::getTextMonth($this->dekatrianNumericMonth);
    }

    private function setDekatrianDayOfMonth(): void
    {
        $this->dekatrianDayOfMonth = match($this->dekatrianDayOfYear) {
            -2 => 1,
            -1 => $this->leapYear ? 2 : 1,
            default => (function () {
                $dayOfMonthCalculated = ($this->dekatrianDayOfYear % 28) + 1;
                return ($dayOfMonthCalculated >= 0) ? $dayOfMonthCalculated : 99;
            })()
        };
    }

    /**
     * @throws DekatrianWeekdayNotFoundException
     * @throws GregorianWeekdayNotFoundException
     */
    private function setDekatrianWeekday(): void
    {
        $this->dekatrianNumericWeekday = match($this->dekatrianDayOfYear >= 0) {
            true => (($this->dekatrianDayOfMonth - 1) % 7),
            false => $this->dekatrianDayOfYear
        };
        $this->dekatrianTextWeekday = $this->getDekatrianTextWeekday($this->dekatrianNumericWeekday);
    }

    /**
     * @throws GregorianWeekdayNotFoundException
     */
    private function getDekatrianWeekdays(): array
    {
        $lastDayGreg = "{$this->gregorianDateInfo['year']}-12-31";
        $yLastDayGreg = getdate(strtotime($lastDayGreg));
        $idxDayOfWeekGreg = GregorianWeekdayEnum::findWeekday($yLastDayGreg['weekday']) + 1;
        $idxFirstDayOfWeek = ($idxDayOfWeekGreg <= 6) ? $idxDayOfWeekGreg : 0;

        $dekatrianWeekdays = [-1 => DekatrianSpecialDayEnum::ACHRONIAN];
        if ($this->leapYear) {
            $dekatrianWeekdays[-2] = DekatrianSpecialDayEnum::ACHRONIAN;
            $dekatrianWeekdays[-1] = DekatrianSpecialDayEnum::SINCHRONIAN;
        }

        $idx = $idxFirstDayOfWeek;
        foreach (GregorianWeekdayEnum::getWeekdays() as $i => $day) {
            $dekatrianWeekdays[$i] = GregorianWeekdayEnum::getWeekday($idx);
            $idx = ($idx < 6) ? ++$idx : 0;
        }

        ksort($dekatrianWeekdays);
        return $dekatrianWeekdays;
    }

    private function setDekatrianYear(): void
    {
        $this->dekatrianYear = $this->gregorianYear;
    }

    private function setDekatrianYearDay(): void
    {
        $diffDays = $this->leapYear ? 2 : 1;
        $this->dekatrianDayOfYear = $this->getGregorianYearDay() - $diffDays;
    }
}
