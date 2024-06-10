<?php
declare(strict_types=1);

namespace TiagoHenrique92\Dekatrian\Exceptions;

use Exception;
use Throwable;

class GregorianInvalidDateException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ?? 'Invalid date';
        parent::__construct($message, $code, $previous);
    }
}