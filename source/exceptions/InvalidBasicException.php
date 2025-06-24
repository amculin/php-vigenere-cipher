<?php
namespace amculin\cryptography\classic\exceptions;

class InvalidBasicException extends \Exception
{
    public function errorMessage(): string
    {
        $message = 'Error on line '.$this->getLine().' in '.$this->getFile().': '.PHP_EOL;
        $message .= $this->getMessage().' is invalid, must be combination of a-z!'.PHP_EOL;

        return $message;
    }
}
