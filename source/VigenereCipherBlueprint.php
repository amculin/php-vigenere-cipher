<?php

namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;

#[\AllowDynamicProperties]
abstract class VigenereCipherBlueprint
{
    /**
     * Default list of acceptable character to be used in vigenere cipher algorithm
     * By default, it just an alphabetical list.
     */
    public string $tabulaRecta;

    /**
     * The current process whether it is encrypt or decrypt.
     */
    public string $process;

    /**
     * The plain text/message to be encrypted.
     */
    public string $plainText = '';

    /**
     * The key used to encrypt plain text/message.
     */
    public string $key;

    /**
     * The isValid attribute to ensure whether the key, plainText, or cipherText
     * is valid.
     */
    public bool $isValid = false;

    /**
     * The cipher text to be decrypted.
     */
    public string $cipherText = '';

    /**
     * Method to validate key, plainText, and cipherText.
     */
    abstract public function isValid(): bool;

    /**
     * Method to validate the key using regex pattern.
     */
    abstract public function isValidKey(string $pattern): bool;

    /**
     * Method to validate the plain text using regex pattern.
     */
    abstract public function isValidPlainText(string $pattern): bool;

    /**
     * Method to validate the cipher text using regex pattern.
     */
    abstract public function isValidCipherText(string $pattern): bool;

    /**
     * Method to get is valid status.
     */
    public function getIsValid(): bool
    {
        return $this->isValid;
    }

    /**
     * Set the is valid status.
     */
    public function setIsValid(bool $isValid): void
    {
        $this->isValid = $isValid;
    }

    /**
     * Method to get current process.
     */
    public function getProcess(): string
    {
        return $this->process;
    }

    /**
     * Set the current process.
     */
    public function setProcess(string $process): void
    {
        $this->process = $process;
    }

    /**
     * Method to get plain text.
     */
    public function getPlainText(): string
    {
        return $this->plainText;
    }

    /**
     * Set the plain text/message/data to be encrypted.
     */
    public function setPlainText(string $plainText): void
    {
        $this->plainText = $plainText;
    }

    /**
     * Method to get key.
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set the key to be be used in encryption/decryption process.
     */
    public function setKey(string $key): void
    {
        $paddedKey = $this->generateKey($key);

        $this->key = $paddedKey;
    }

    /**
     * Method to get cipher text.
     */
    public function getCipherText(): string
    {
        return $this->cipherText;
    }

    /**
     * Set the cipher text result from encryption process.
     */
    public function setCipherText(string $cipherText): void
    {
        $this->cipherText = $cipherText;
    }

    /**
     * Method to generate the key
     * We loop the key then concatenate it until it has the same length with the plain text
     * Example:
     *     Plain text: vigenerecipher (14 characters)
     *     Key: abcd (4 characters)
     *     Repeated key: abcdabcdabcdab (14 characters).
     */
    public function generateKey(string $key): string
    {
        $keyLength = strlen($key);
        $messageLength = strlen($this->process == ProcessType::ENCRYPT->value ? $this->plainText
            : $this->cipherText);

        $repeatTimes = floor($messageLength / $keyLength);
        $paddingKeyLength = (int) ($messageLength - ($keyLength * $repeatTimes));

        $repeatedKey = '';

        for ($i = 0; $i < $repeatTimes; ++$i) {
            $repeatedKey .= $key;
        }

        return $repeatedKey.substr($key, 0, $paddingKeyLength);
    }

    /**
     * Method to encrypt the plain text.
     */
    public function encrypt(): void
    {
        $messageLength = strlen($this->plainText);
        $cipher = '';

        for ($i = 0; $i < $messageLength; ++$i) {
            $messageCharPosition = strpos($this->tabulaRecta, substr($this->plainText, $i, 1));
            $keyCharPosition = strpos($this->tabulaRecta, substr($this->key, $i, 1));

            if (false !== $messageCharPosition && false !== $keyCharPosition) {
                $shift = $messageCharPosition + $keyCharPosition;
                $cipherCharPosition = $shift % strlen($this->tabulaRecta);
                $cipher .= substr($this->tabulaRecta, $cipherCharPosition, 1);
            }
        }

        $this->setCipherText($cipher);
    }

    /**
     * Method to decrypt the cipher text.
     */
    public function decrypt(): void
    {
        $messageLength = strlen($this->cipherText);
        $plain = '';

        for ($i = 0; $i < $messageLength; ++$i) {
            $messageCharPosition = strpos($this->tabulaRecta, substr($this->cipherText, $i, 1));
            $keyCharPosition = strpos($this->tabulaRecta, substr($this->key, $i, 1));

            if (false !== $messageCharPosition && false !== $keyCharPosition) {
                $shift = $messageCharPosition - $keyCharPosition;
                $plainCharPosition = $shift % strlen($this->tabulaRecta);

                $plain .= substr($this->tabulaRecta, $plainCharPosition, 1);
            }
        }

        $this->setPlainText($plain);
    }
}
