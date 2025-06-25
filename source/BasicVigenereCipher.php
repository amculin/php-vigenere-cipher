<?php

namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\exceptions\InvalidBasicException;

/**
 * This file is the main class for basic vigenere cipher algortithm.
 *
 * @author Fahmi Auliya Tsani <amixcustomlinux@gmail.com>
 *
 * @version 1.1
 *
 * @psalm-api
 */
#[\AllowDynamicProperties]
class BasicVigenereCipher extends VigenereCipherBlueprint
{
    public function __construct(
        public string $data,
        public string $key,
        public string $process = 'encrypt'
    ) {
        $this->process = $process;
        $this->tabulaRecta = 'abcdefghijklmnopqrstuvwxyz';

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
            $pattern = '/^[a-z]*$/';

            if (!$this->isValidKey($pattern)) {
                throw new InvalidBasicException('Key');
            }

            if ($this->process == ProcessType::ENCRYPT->value) {
                if (!$this->isValidPlainText($pattern)) {
                    throw new InvalidBasicException('Plain text');
                }
            } else {
                if (!$this->isValidCipherText($pattern)) {
                    throw new InvalidBasicException('Cipher text');
                }
            }
        } catch (InvalidBasicException $e) {
            echo $e->errorMessage();

            return false;
        }

        $this->setIsValid(true);

        return true;
    }
}
