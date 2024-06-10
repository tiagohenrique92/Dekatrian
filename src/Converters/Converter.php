<?php

namespace TiagoHenrique92\Dekatrian\Converters;

use TiagoHenrique92\Dekatrian\Entities\BaseDateInterface;

interface Converter
{
    /**
     * @param string $receivedDate
     * @param string|null $timezone
     * @return BaseDateInterface
     */
    public function convert(string $receivedDate, string $timezone = null): BaseDateInterface;
}
