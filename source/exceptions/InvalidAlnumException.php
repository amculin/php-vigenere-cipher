<?php
namespace amculin\cryptography\classic\exceptions;

class InvalidAlnumException extends \Exception
{
    public function errorMessage(): string
    {
        $message = 'Error on line '.$this->getLine().' in '.$this->getFile().': '.PHP_EOL;
        $message .= $this->getMessage().' is invalid, must be combination of a-z, A-Z, and 0-9!'.PHP_EOL;

        return $message;
    }
}
