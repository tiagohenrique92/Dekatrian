<?php

declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Factories;

use TiagoHenrique92\Dekatrian\Converters\GregorianConverter;
use TiagoHenrique92\Dekatrian\Entities\GregorianDate;

class GregorianDateFactory
{
    /**
     * @param string $date
     * @param string|null $timezone
     * @return GregorianDate
     */
    public static function createFromDekatrian(string $date, string $timezone = null): GregorianDate
    {
        return (new GregorianConverter())->convert($date, $timezone);
    }
}
