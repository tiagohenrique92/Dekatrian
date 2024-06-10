<?php

namespace TiagoHenrique92\Dekatrian\Converters;

use TiagoHenrique92\Dekatrian\Entities\BaseDateEntity;

abstract class AbstractConverter
{
    protected BaseDateEntity $baseDateEntity;

    public function __construct()
    {
        $this->baseDateEntity = new BaseDateEntity();
    }

    /**
     * @param string $receivedDate
     * @param string|null $timezone
     * @return BaseDateEntity
     */
    public abstract function convert(string $receivedDate, string $timezone = null): BaseDateEntity;

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->baseDateEntity->getDate();
    }
}