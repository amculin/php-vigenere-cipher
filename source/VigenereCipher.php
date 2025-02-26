<?php
namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\enums\VigenereMode;

class VigenereCipher
{
    public static function getClassName(string $mode): string
    {
        $path = 'amculin\cryptography\classic\\';

        if ($mode == VigenereMode::BASIC->value) {
            return $path . 'BasicVigenereCipher';
        } elseif ($mode == VigenereMode::ALPHA_NUMERIC->value) {
            return $path . 'AlnumVigenereCipher';
        }
    }

    public static function encrypt(string $data, string $key, string $mode = 'basic'): string|null
    {
        $className = self::getClassName($mode);

        $processName = ProcessType::ENCRYPT->value;

        $encrypt = new $className($processName, $data, $key);

        return $encrypt->getCipherText();
    }

    public static function decrypt(string $data, string $key, string $mode = 'basic'): string|null
    {
        $className = self::getClassName($mode);

        $processName = ProcessType::DECRYPT->value;

        $decrypt = new $className($processName, $data, $key);

        return $decrypt->getPlainText();
    }
}
