<?php

namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\enums\VigenereMode;

/**
 * @psalm-api
 */
class VigenereCipher
{
    public static function getClassName(string $mode): string
    {
        $path = 'amculin\cryptography\classic\\';
        $className = 'BasicVigenereCipher';

        if ($mode == VigenereMode::ALPHA_NUMERIC->value) {
            $className = 'AlnumVigenereCipher';
        }

        return $path.$className;
    }

    public static function getClass(
        string $data,
        string $key,
        string $processName,
        string $mode
    ): VigenereCipherBlueprint {
        if ($mode == VigenereMode::ALPHA_NUMERIC->value) {
            return new AlnumVigenereCipher($data, $key, $processName);
        }
        if ($mode == VigenereMode::BASE64->value) {
            return new Base64VigenereCipher($data, $key, $processName);
        }

        return new BasicVigenereCipher($data, $key, $processName);
    }

    public static function encrypt(string $data, string $key, string $mode = 'basic'): string
    {
        $processName = ProcessType::ENCRYPT->value;

        $encrypt = self::getClass($data, $key, $processName, $mode);

        return $encrypt->cipherText;
    }

    public static function decrypt(string $data, string $key, string $mode = 'basic'): string
    {
        $processName = ProcessType::DECRYPT->value;

        $decrypt = self::getClass($data, $key, $processName, $mode);

        return $decrypt->plainText;
    }
}
