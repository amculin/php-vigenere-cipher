<?php
namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;

abstract class VigenereCipherBlueprint
{
    /**
     * Default list of acceptable character to be used in vigenere cipher algorithm
     * By default, it just an alphabetical list.
     *
     * @var string
     */
    public string $tabulaRecta;

    /**
     * The current process whether it is encrypt or decrypt
     *
     * @var string
     */
    public string $process;

    /**
     * The plain text/message to be encrypted
     *
     * @var string
     */
    public string $plainText;

    /**
     * The key used to encrypt plain text/message
     *
     * @var string
     */
    public string $key;

    /**
     * The isValid attribute to ensure whether the key, plainText, or cipherText
     * is valid
     *
     * @var bool
     */
    public bool $isValid = false;

    /**
     * The cipher text to be decrypted
     *
     * @var string
     */
    public string $cipherText;

    /**
     * Method to validate key, plainText, and cipherText
     *
     * @return bool
     */
    abstract public function isValid(): bool;

    /**
     * Method to validate the key using regex pattern
     *
     * @param string $pattern
     * @return bool
     */
    abstract public function isValidKey(string $pattern): bool;

    /**
     * Method to validate the plain text using regex pattern
     *
     * @param string $pattern
     * @return bool
     */
    abstract public function isValidPlainText(string $pattern): bool;

    /**
     * Method to validate the cipher text using regex pattern
     *
     * @param string $pattern
     * @return bool
     */
    abstract public function isValidCipherText(string $pattern): bool;

    /**
     * Method to get is valid status
     *
     * @return bool
     */
    public function getIsValid(): bool
    {
        return $this->isValid;
    }

    /**
     * Set the is valid status
     *
     * @param bool $isValid
     * @return void
     */
    public function setIsValid(bool $isValid): void
    {
        $this->isValid = $isValid;
    }

    /**
     * Method to get current process
     *
     * @return string
     */
    public function getProcess(): string
    {
        return $this->process;
    }

    /**
     * Set the current process
     *
     * @param string $process
     * @return void
     */
    public function setProcess(string $process): void
    {
        $this->process = $process;
    }

    /**
     * Method to get plain text
     *
     * @return string
     */
    public function getPlainText(): string|null
    {
        return $this->plainText;
    }

    /**
     * Set the plain text/message/data to be encrypted
     *
     * @param string $plainText
     * @return void
     */
    public function setPlainText(string $plainText): void
    {
        $this->plainText = $plainText;
    }

    /**
     * Method to get key
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set the key to be be used in encryption/decryption process
     *
     * @param string $key
     * @return void
     */
    public function setKey(string $key): void
    {
        $paddedKey = $this->generateKey($key);

        $this->key = $paddedKey;
    }

    /**
     * Method to get cipher text
     *
     * @return string
     */
    public function getCipherText(): string|null
    {
        return $this->cipherText;
    }

    /**
     * Set the cipher text result from encryption process
     *
     * @param string $cipherText
     * @return void
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
     *     Repeated key: abcdabcdabcdab (14 characters)
     *
     * @param string $key
     * @return string
     */
    public function generateKey(string $key): string
    {
        $keyLength = strlen($key);
        $messageLength = strlen($this->process == ProcessType::ENCRYPT->value ? $this->plainText :
            $this->cipherText);

        $repeatTimes = floor($messageLength / $keyLength);
        $paddingKeyLength = (int) ($messageLength - ($keyLength * $repeatTimes));
        
        $repeatedKey = '';

        for ($i = 0; $i < $repeatTimes; $i++) {
            $repeatedKey .= $key;
        }
        
        return $repeatedKey . substr($key, 0, $paddingKeyLength);
    }

    /**
     * Method to encrypt the plain text
     *
     * @return void
     */
    public function encrypt(): void
    {
        $messageLength = strlen($this->plainText);
        $cipher = '';
        
        for ($i = 0; $i < $messageLength; $i++) {
            $messageCharPosition = strpos($this->tabulaRecta, substr($this->plainText, $i, 1));
            $keyCharPosition = strpos($this->tabulaRecta, substr($this->key, $i, 1));
            
            $shift = $messageCharPosition + $keyCharPosition;
            $cipherCharPosition = $shift % strlen($this->tabulaRecta);
            $cipher .= substr($this->tabulaRecta, $cipherCharPosition, 1);
        }

        $this->setCipherText($cipher);
    }

    /**
     * Method to decrypt the cipher text
     *
     * @return void
     */
    public function decrypt(): void
    {
        $messageLength = strlen($this->cipherText);
        $plain = '';
        
        for ($i = 0; $i < $messageLength; $i++) {
            $messageCharPosition = strpos($this->tabulaRecta, substr($this->cipherText, $i, 1));
            $keyCharPosition = strpos($this->tabulaRecta, substr($this->key, $i, 1));
            
            $shift = $messageCharPosition - $keyCharPosition;
            $plainCharPosition = $shift % strlen($this->tabulaRecta);

            $plain .= substr($this->tabulaRecta, $plainCharPosition, 1);
        }
        
        $this->setPlainText($plain);
    }
}
