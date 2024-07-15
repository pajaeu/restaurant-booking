<?php

namespace App\Exceptions;

class BookingException extends \Exception
{


    /**
     * @throws BookingException
     */
    public static function tableNotAvailable(): void
    {
        throw new self('V tento čas není žádný stůl k dispozici.');
    }

    /**
     * @throws BookingException
     */
    public static function selectedTableNotAvailable(): void
    {
        throw new self('Tento stůl již není k dispozici.');
    }
}
