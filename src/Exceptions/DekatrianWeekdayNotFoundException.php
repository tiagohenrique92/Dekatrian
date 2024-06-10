<?php
declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Exceptions;

use Exception;
use Throwable;

class DekatrianWeekdayNotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ?? 'Weekday not found';
        parent::__construct($message, $code, $previous);
    }
}