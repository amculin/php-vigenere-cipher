<?php
namespace amculin\cryptography\classic;

use amculin\cryptography\classic\VigenereCipherBlueprint;
use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\enums\VigenereMode;

class VigenereCipher
{
    public static function getClassName(string $mode): string
    {
        $path = 'amculin\cryptography\classic\\';
        $className = 'BasicVigenereCipher';

        if ($mode == VigenereMode::ALPHA_NUMERIC->value) {
            $className = 'AlnumVigenereCipher';
        }

        return $path . $className;
    }

    public static function encrypt(string $data, string $key, string $mode = 'basic'): string
    {
        $className = self::getClassName($mode);

        $processName = ProcessType::ENCRYPT->value;

        /** @var VigenereCipherBlueprint $encrypt */
        $encrypt = new $className($data, $key, $processName);

        return $encrypt->cipherText;
    }

    public static function decrypt(string $data, string $key, string $mode = 'basic'): string
    {
        $className = self::getClassName($mode);

        $processName = ProcessType::DECRYPT->value;

        /** @var VigenereCipherBlueprint $decrypt */
        $decrypt = new $className($data, $key, $processName);

        return $decrypt->plainText;
    }
}
