<?php

namespace App\Exceptions\ValueObjects;

use Exception;

class Vector2DInvalidArgumentException extends Exception
{
    protected $message = 'Vector2D invalid argument';
    protected $code = 500;

    public function __construct($message = null, $code = null, Exception $previous = null)
    {
        if ($message) {
            $this->message = $message;
        }

        if ($code) {
            $this->code = $code;
        }

        parent::__construct($this->message, $this->code, $previous);
    }
}
