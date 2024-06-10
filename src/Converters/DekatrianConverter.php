<?php
declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Converters;

use TiagoHenrique92\Dekatrian\Entities\BaseDateEntity;
use TiagoHenrique92\Dekatrian\Enums\DekatrianMonthEnum;
use TiagoHenrique92\Dekatrian\Enums\DekatrianSpecialDayEnum;
use TiagoHenrique92\Dekatrian\Enums\GregorianWeekdayEnum;
use TiagoHenrique92\Dekatrian\Exceptions\DekatrianWeekdayNotFoundException;

class DekatrianConverter extends AbstractConverter
{
    private array $gregorianDateInfo;
    private int $gregorianTimestamp;
    private int $gregorianSeconds;
    private int $gregorianMinutes;
    private int $gregorianHours;
    private int $gregorianYear;

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
        $this->gregorianSeconds = $this->gregorianDateInfo['seconds'];
        $this->gregorianMinutes = $this->gregorianDateInfo['minutes'];
        $this->gregorianHours = $this->gregorianDateInfo['hours'];
        $this->gregorianYear = $this->gregorianDateInfo['year'];
    }

    private function getGregorianYearDay(): int
    {
        return $this->gregorianDateInfo['yday'];
    }

    /**
     * @param int $numericWeekday
     * @return string
     * @throws Exception
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
        $leapYear = (bool) date('L', $this->gregorianTimestamp);
        $this->baseDateEntity->setLeapYear($leapYear);
    }

    private function setDekatrianMonth(): void
    {
        $idxMonth = intval($this->baseDateEntity->getDayOfYear() / 28) + 1;
        $this->baseDateEntity->setNumericMonth($idxMonth);
        $this->baseDateEntity->setTextMonth(DekatrianMonthEnum::getTextMonth($idxMonth));
    }

    private function setDekatrianDayOfMonth(): void
    {
        $dayOfMonthCalculated = ($this->baseDateEntity->getDayOfYear() % 28) + 1;
        $dayOfMonth = ($dayOfMonthCalculated >= 0) ? $dayOfMonthCalculated : 99;
        $this->baseDateEntity->setDayOfMonth($dayOfMonth);
    }

    private function setDekatrianWeekday(): void
    {
        $dekatrianDayOfYear = $this->baseDateEntity->getDayOfYear();
        $dekatrianDayOfMonth = $this->baseDateEntity->getDayOfMonth();
        $numericWeekday = ($dekatrianDayOfYear >= 0) ? ($dekatrianDayOfMonth - 1) % 7 : $dekatrianDayOfYear;
        $this->baseDateEntity->setNumericWeekday($numericWeekday);
        $this->baseDateEntity->setTextWeekday($this->getDekatrianTextWeekday($numericWeekday));
    }

    private function getDekatrianWeekdays(): array
    {
        $lastDayGreg = "{$this->gregorianDateInfo['year']}-12-31";
        $yLastDayGreg = getdate(strtotime($lastDayGreg));
        $idxDayOfWeekGreg = GregorianWeekdayEnum::findWeekday($yLastDayGreg['weekday']) + 1;
        $idxFirstDayOfWeek = ($idxDayOfWeekGreg <= 6) ? $idxDayOfWeekGreg : 0;

        $dekatrianWeekdays = [-1 => DekatrianSpecialDayEnum::ACHRONIAN];
        if ($this->baseDateEntity->isLeapYear()) {
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
        $this->baseDateEntity->setYear($this->gregorianYear);
    }

    private function setDekatrianYearDay(): void
    {
        $diffDays = $this->baseDateEntity->isLeapYear() ? 2 : 1;
        $this->baseDateEntity->setDayOfYear($this->getGregorianYearDay() - $diffDays);
    }
}