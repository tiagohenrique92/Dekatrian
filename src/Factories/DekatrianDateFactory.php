<?php

declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Factories;

use TiagoHenrique92\Dekatrian\Converters\DekatrianConverter;
use TiagoHenrique92\Dekatrian\Converters\GregorianConverter;
use TiagoHenrique92\Dekatrian\Entities\DekatrianDate;
use TiagoHenrique92\Dekatrian\Exceptions\DekatrianMonthNotFoundException;
use TiagoHenrique92\Dekatrian\Exceptions\DekatrianWeekdayNotFoundException;
use TiagoHenrique92\Dekatrian\Exceptions\GregorianWeekdayNotFoundException;

class DekatrianDateFactory
{
    /**
     * @param string $date
     * @param string|null $timezone
     * @return DekatrianDate
     * @throws DekatrianMonthNotFoundException
     * @throws DekatrianWeekdayNotFoundException
     * @throws GregorianWeekdayNotFoundException
     */
    public static function createFromDekatrian(string $date, string $timezone = null): DekatrianDate
    {
        $gregorianDate = (new GregorianConverter())->convert($date, $timezone);
        return (new DekatrianConverter())->convert($gregorianDate->getDate(), $timezone);
    }

    /**
     * @param string $date
     * @param string|null $timezone
     * @return DekatrianDate
     * @throws DekatrianMonthNotFoundException
     * @throws DekatrianWeekdayNotFoundException
     * @throws GregorianWeekdayNotFoundException
     */
    public static function createFromGregorian(string $date, string $timezone = null): DekatrianDate
    {
        return (new DekatrianConverter())->convert($date, $timezone);
    }
}
