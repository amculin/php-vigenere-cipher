<?php

namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\exceptions\InvalidBase64Exception;

/**
 * This file is the main class for basic vigenere cipher algortithm.
 *
 * @author Fahmi Auliya Tsani <amixcustomlinux@gmail.com>
 *
 * @version 1.2
 *
 * @psalm-api
 */
#[\AllowDynamicProperties]
class Base64VigenereCipher extends VigenereCipherBlueprint
{
    public function __construct(
        public string $data,
        public string $key,
        public string $process = 'encrypt'
    ) {
        $this->process = $process;
        $this->tabulaRecta = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

        if ($process == ProcessType::ENCRYPT->value) {
            $this->plainText = $data;
            $this->key = $this->generateKey($key);

            if ($this->isValid()) {
                $this->encrypt();
            }
        } else {
            $this->cipherText = $data;
            $this->key = $this->generateKey($key);

            if ($this->isValid()) {
                $this->decrypt();
            }
        }
    }

    public function isValidKey(string $pattern): bool
    {
        if ('' != $pattern) {
            return 1 == preg_match($pattern, $this->key);
        }

        return false;
    }

    public function isValidPlainText(string $pattern): bool
    {
        if ('' != $pattern) {
            return 1 == preg_match($pattern, $this->plainText);
        }

        return false;
    }

    public function isValidCipherText(string $pattern): bool
    {
        if ('' != $pattern) {
            return 1 == preg_match($pattern, $this->cipherText);
        }

        return false;
    }

    public function isValid(): bool
    {
        try {
            $pattern = '/^[A-Za-z0-9+\/=]+$/';

            if (!$this->isValidKey($pattern)) {
                throw new InvalidBase64Exception('Key');
            }

            if ($this->process == ProcessType::ENCRYPT->value) {
                if (!$this->isValidPlainText($pattern)) {
                    throw new InvalidBase64Exception('Plain text');
                }
            } else {
                if (!$this->isValidCipherText($pattern)) {
                    throw new InvalidBase64Exception('Cipher text');
                }
            }
        } catch (InvalidBase64Exception $e) {
            echo $e->errorMessage();

            return false;
        }

        $this->setIsValid(true);

        return true;
    }
}
