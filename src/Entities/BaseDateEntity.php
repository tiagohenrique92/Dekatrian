<?php
declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Entities;

class BaseDateEntity
{
    protected int $year;
    protected int $dayOfYear;
    protected int $dayOfMonth;
    protected bool $leapYear;
    protected int $numericMonth;
    protected string $textMonth;
    protected string $textWeekday;
    protected int $numericWeekday;

    /**
     * @return array
     */
    public function getDateInfo(): array
    {
        return [
            'mday' => $this->dayOfMonth,
            'wday' => $this->numericWeekday,
            'mon' => $this->numericMonth,
            'year' => $this->year,
            'yday' => $this->dayOfYear,
            'weekday' => $this->textWeekday,
            'month' => $this->textMonth,
        ];
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        $month = str_pad((string) $this->numericMonth, 2, '0', STR_PAD_LEFT);
        $day = str_pad((string) $this->dayOfMonth, 2, '0', STR_PAD_LEFT);
        return "{$this->year}-{$month}-{$day}";
    }

    /**
     * @return int
     */
    public function getDayOfYear(): int
    {
        return $this->dayOfYear;
    }

    /**
     * @return int
     */
    public function getDayOfMonth(): int
    {
        return $this->dayOfMonth;
    }

    /**
     * @return int
     */
    public function getNumericMonth(): int
    {
        return $this->numericMonth;
    }

    /**
     * @return string
     */
    public function getTextMonth(): string
    {
        return $this->textMonth;
    }

    /**
     * @return string
     */
    public function getTextWeekday(): string
    {
        return $this->textWeekday;
    }

    /**
     * @return bool
     */
    public function isLeapYear(): bool
    {
        return $this->leapYear;
    }

    /**
     * @param int $dayOfMonth
     * @throws Exception
     */
    public function setDayOfMonth(int $dayOfMonth): void
    {
        if (isset($this->dayOfMonth)) {
            throw new Exception('Day of month has been setted');
        }

        $this->dayOfMonth = $dayOfMonth;
    }

    /**
     * @param int $dayOfYear
     * @throws Exception
     */
    public function setDayOfYear(int $dayOfYear): void
    {
        if (isset($this->dayOfYear)) {
            throw new Exception('Day of year has been setted');
        }

        $this->dayOfYear = $dayOfYear;
    }

    /**
     * @param bool $leapYear
     * @throws Exception
     */
    public function setLeapYear(bool $leapYear): void
    {
        if (isset($this->leapYear)) {
            throw new Exception('Leap year has been setted');
        }

        $this->leapYear = $leapYear;
    }

    /**
     * @param int $numericMonth
     * @throws Exception
     */
    public function setNumericMonth(int $numericMonth): void
    {
        if (isset($this->numericMonth)) {
            throw new Exception('Numeric month has been setted');
        }

        $this->numericMonth = $numericMonth;
    }

    /**
     * @param string $textMonth
     * @throws Exception
     */
    public function setTextMonth(string $textMonth): void
    {
        if (isset($this->textMonth)) {
            throw new Exception('Text month has been setted');
        }

        $this->textMonth = $textMonth;
    }

    /**
     * @param string $textWeekday
     * @throws Exception
     */
    public function setTextWeekday(string $textWeekday): void
    {
        if (isset($this->textWeekday)) {
            throw new Exception('Text weekday has been setted');
        }

        $this->textWeekday = $textWeekday;
    }

    /**
     * @param int $numericWeekday
     * @throws Exception
     */
    public function setNumericWeekday(int $numericWeekday): void
    {
        if (isset($this->numericWeekday)) {
            throw new Exception('Numeric weekday has been setted');
        }

        $this->numericWeekday = $numericWeekday;
    }

    /**
     * @param int $year
     * @throws Exception
     */
    public function setYear(int $year): void
    {
        if (isset($this->year)) {
            throw new Exception('Year has been setted');
        }

        $this->year = $year;
    }
}