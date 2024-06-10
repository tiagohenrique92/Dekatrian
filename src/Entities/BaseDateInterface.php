<?php

namespace TiagoHenrique92\Dekatrian\Entities;

use Exception;

interface BaseDateInterface
{
    /**
     * @return array
     */
    public function getDateInfo(): array;

    /**
     * @return string
     */
    public function getDate(): string;

    /**
     * @return int
     */
    public function getDayOfYear(): int;

    /**
     * @return int
     */
    public function getDayOfMonth(): int;

    /**
     * @return int
     */
    public function getNumericMonth(): int;

    /**
     * @return string
     */
    public function getTextMonth(): string;

    /**
     * @return string
     */
    public function getTextWeekday(): string;

    /**
     * @return bool
     */
    public function isLeapYear(): bool;

    /**
     * @param int $dayOfMonth
     * @throws Exception
     */
    public function setDayOfMonth(int $dayOfMonth): void;

    /**
     * @param int $dayOfYear
     * @throws Exception
     */
    public function setDayOfYear(int $dayOfYear): void;

    /**
     * @param bool $leapYear
     * @throws Exception
     */
    public function setLeapYear(bool $leapYear): void;

    /**
     * @param int $numericMonth
     * @throws Exception
     */
    public function setNumericMonth(int $numericMonth): void;

    /**
     * @param string $textMonth
     * @throws Exception
     */
    public function setTextMonth(string $textMonth): void;

    /**
     * @param string $textWeekday
     * @throws Exception
     */
    public function setTextWeekday(string $textWeekday): void;

    /**
     * @param int $numericWeekday
     * @throws Exception
     */
    public function setNumericWeekday(int $numericWeekday): void;

    /**
     * @param int $year
     * @throws Exception
     */
    public function setYear(int $year): void;
}
