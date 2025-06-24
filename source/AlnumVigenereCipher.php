<?php
namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\exceptions\InvalidAlnumException;

/**
 * This file is the main class for alpha-numric mode vigenere cipher algortithm
 *
 * @author Fahmi Auliya Tsani <amixcustomlinux@gmail.com>
 * @version 1.1
 */
class AlnumVigenereCipher extends VigenereCipherBlueprint
{
    public function __construct(
        public string $data,
        public string $key,
        public string $process = 'encrypt'
    ) {
        $this->process = $process;
        $this->tabulaRecta = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

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

    /**
     * @inheritdoc
     */
    public function isValidKey(string $pattern): bool
    {
        return preg_match($pattern, $this->key) == 1;
    }

    /**
     * @inheritdoc
     */
    public function isValidPlainText(string $pattern): bool
    {
        return preg_match($pattern, $this->plainText) == 1;
    }

    /**
     * @inheritdoc
     */
    public function isValidCipherText(string $pattern): bool
    {
        return preg_match($pattern, $this->cipherText) == 1;
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        try {
            $pattern = '/^[a-zA-Z0-9]*$/';

            if (! $this->isValidKey($pattern)) {
                throw new InvalidAlnumException('Key');
            }

            if ($this->process == ProcessType::ENCRYPT->value) {
                if (! $this->isValidPlainText($pattern)) {
                    throw new InvalidAlnumException('Plain text');
                }
            } else {
                if (! $this->isValidCipherText($pattern)) {
                    throw new InvalidAlnumException('Cipher text');
                }
            }
        } catch(InvalidAlnumException $e) {
            echo $e->errorMessage();

            return false;
        }

        $this->setIsValid(true);
        return true;
    }
}
