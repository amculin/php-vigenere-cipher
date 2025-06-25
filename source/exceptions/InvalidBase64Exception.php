<?php

namespace amculin\cryptography\classic\exceptions;

class InvalidBase64Exception extends \Exception
{
    public function errorMessage(): string
    {
        $message = 'Error on line '.$this->getLine().' in '.$this->getFile().': '.PHP_EOL;
        $message .= $this->getMessage().' is invalid, must be combination of A-z, a-z, 0-9, and +/='.PHP_EOL;

        return $message;
    }
}
