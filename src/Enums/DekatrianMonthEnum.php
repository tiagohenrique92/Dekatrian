<?php

namespace TiagoHenrique92\Dekatrian\Enums;

use TiagoHenrique92\Dekatrian\Exceptions\DekatrianMonthNotFoundException;

class DekatrianMonthEnum
{
    public const OUT_OF_TIME = 'Out Of Time';
    public const AURORAN = 'Auroran';
    public const BOREAN = 'Borean';
    public const CORONIAN = 'Coronian';
    public const DRIADAN = 'Driadan';
    public const ELECTRAN = 'Electran';
    public const FAIAN = 'Faian';
    public const GAIAN = 'Gaian';
    public const HERMETIAN = 'Hermetian';
    public const IRISIAN = 'Irisian';
    public const KAOSIAN = 'Kaosian';
    public const LUNAN = 'Lunan';
    public const MAIAN = 'Maian';
    public const NIXIAN = 'Nixian';

    private static array $textMonths = [
        0 => self::OUT_OF_TIME,
        1 => self::AURORAN,
        2 => self::BOREAN,
        3 => self::CORONIAN,
        4 => self::DRIADAN,
        5 => self::ELECTRAN,
        6 => self::FAIAN,
        7 => self::GAIAN,
        8 => self::HERMETIAN,
        9 => self::IRISIAN,
        10 => self::KAOSIAN,
        11 => self::LUNAN,
        12 => self::MAIAN,
        13 => self::NIXIAN
    ];

    /**
     * @param int $numericMonth
     * @return string
     * @throws DekatrianMonthNotFoundException
     */
    public static function getTextMonth(int $numericMonth): string
    {
        if (isset(self::$textMonths[$numericMonth])) {
            return self::$textMonths[$numericMonth];
        }

        throw new DekatrianMonthNotFoundException();
    }
}
