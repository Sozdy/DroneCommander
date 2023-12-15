<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class OutOfBoundException extends Exception
{
    protected $message = 'Position is out of bounds';

    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function render()
    {
        abort($this->code, $this->message);
    }
}
