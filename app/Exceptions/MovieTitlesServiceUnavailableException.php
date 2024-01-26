<?php

namespace App\Exceptions;

use Exception;

class MovieTitlesServiceUnavailableException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::error('Service is unavailable: ' . $this->getMessage());
    }
}
