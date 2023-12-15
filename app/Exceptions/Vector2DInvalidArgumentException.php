<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Vector2DInvalidArgumentException extends Exception
{
    protected $message = 'Invalid Vector2D argument';

    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function render(){
        abort($this->code, $this->message);
    }
}
