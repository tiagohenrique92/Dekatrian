<?php
declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Enums;

use TiagoHenrique92\Dekatrian\Exceptions\GregorianWeekdayNotFoundException;

class GregorianWeekdayEnum
{
    const SUNDAY = 'Sunday';
    const MONDAY = 'Monday';
    const TUESDAY = 'Tuesday';
    const WEDNESDAY = 'Wednesday';
    const THURSDAY = 'Thursday';
    const FRIDAY = 'Friday';
    const SATURDAY = 'Saturday';

    private static $weekdays = [
        0 => self::SUNDAY,
        1 => self::MONDAY,
        2 => self::TUESDAY,
        3 => self::WEDNESDAY,
        4 => self::THURSDAY,
        5 => self::FRIDAY,
        6 => self::SATURDAY
    ];

    /**
     * @param string $name
     * @return int|false
     */
    public static function findWeekday(string $name): int|false
    {
        return array_search($name, self::$weekdays);
    }

    /**
     * @param int $numericWeekday
     * @return string
     * @throws Exception
     */
    public static function getWeekday(int $numericWeekday): string
    {
        if (isset(self::$weekdays[$numericWeekday])) {
            return self::$weekdays[$numericWeekday];
        }

        throw new GregorianWeekdayNotFoundException();
    }

    /**
     * @return string[]
     */
    public static function getWeekdays(): array
    {
        return self::$weekdays;
    }
}