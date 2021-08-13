<?php

namespace App\Exceptions;

use ErrorException;
use Exception;

class UnexpectedImageDataException extends Exception
{
    public function __construct(ErrorException $e)
    {
        parent::__construct('', 0, $e);
    }
}
