<?php
namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\enums\VigenereMode;

class VigenereCipher
{
    public static function getClass(
        string $data,
        string $key,
        string $processName,
        string $mode
    ): VigenereCipherBlueprint {
        if ($mode == VigenereMode::ALPHA_NUMERIC->value) {
            return new AlnumVigenereCipher($data, $key, $processName);
        } elseif ($mode == VigenereMode::BASE64->value) {
            return new Base64VigenereCipher($data, $key, $processName);
        }

        return new BasicVigenereCipher($data, $key, $processName);
    }

    public static function encrypt(string $data, string $key, string $mode = 'basic'): string
    {
        $processName = ProcessType::ENCRYPT->value;

        /** @var VigenereCipherBlueprint $encrypt */
        $encrypt = self::getClass($data, $key, $processName, $mode);

        return $encrypt->cipherText;
    }

    public static function decrypt(string $data, string $key, string $mode = 'basic'): string|null
    {
        $processName = ProcessType::DECRYPT->value;

        /** @var VigenereCipherBlueprint $decrypt */
        $decrypt = self::getClass($data, $key, $processName, $mode);

        return $decrypt->plainText;
    }
}
