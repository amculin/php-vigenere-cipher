<?php
namespace amculin\cryptography\classic;

/**
 * This file is the main class for vigenere cipher encryption algortithm
 *
 * @author Fahmi Auliya Tsani <amixcustomlinux@gmail.com>
 * @version 0.2
 */

class VigenereCipher
{
    /**
     * Default list of acceptable character to be encrypted using vigenere
     * By default, it just an alphabetical list.
     *
     * @var string
     */
    const TABULA_RECTA = 'abcdefghijklmnopqrstuvwxyz';

    /**
     * Mode for encryption process
     *
     * @var string
     */
    const ENCRYPT_MODE = 'encrypt';
    
    /**
     * Mode for decryption process
     *
     * @var string
     */
    const DECRYPT_MODE = 'decrypt';

    /**
     * The mode of current process whether it is encrypt mode or decrypt mode
     *
     * @var string
     */
    public $mode;

    /**
     * The plain text/message to be encrypted
     *
     * @var string
     */
    public $plainText;

    /**
     * The key used to encrypt plain text/message
     *
     * @var string
     */
    public $key;

    /**
     * The cipher text to be decrypted
     *
     * @var string
     */
    public $cipherText;

    public function __construct(string $mode = 'encrypt', string $data = null, string $key = null)
    {
        $this->setMode($mode);

        if ($mode == $this::ENCRYPT_MODE) {
            if (! is_null($data) && ! is_null($key)) {
                $this->setPlainText($data);
                $this->setKey($key);
                $this->encrypt();
            }
        } else {
            if (! is_null($data) && ! is_null($key)) {
                $this->setCipherText($data);
                $this->setKey($key);
                $this->decrypt();
            }
        }
    }

    /**
     * Method to get current mode
     *
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Set the current mode
     *
     * @param string mode
     * @return void
     */
    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * Method to get plain text
     *
     * @return string
     */
    public function getPlainText(): string
    {
        return $this->plainText;
    }

    /**
     * Set the plain text/message/data to be encrypted
     *
     * @param string message
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
     * @param string key
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
    public function getCipherText(): string
    {
        return $this->cipherText;
    }

    /**
     * Set the cipher text result from encryption process
     *
     * @param string message
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
     * @param string key
     * @return string
     */
    public function generateKey(string $key): string
    {
        $keyLength = strlen($key);
        $messageLength = strlen($this->mode == $this::ENCRYPT_MODE ? $this->plainText : $this->cipherText);

        $repeatTimes = floor($messageLength / $keyLength);
        $paddingKeyLength = $messageLength - ($keyLength * $repeatTimes);
        
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
            $messageCharPosition = strpos(self::TABULA_RECTA, substr($this->plainText, $i, 1));
            $keyCharPosition = strpos(self::TABULA_RECTA, substr($this->key, $i, 1));
            
            $shift = $messageCharPosition + $keyCharPosition;
            $cipherCharPosition = $shift % strlen(self::TABULA_RECTA);
            $cipher .= substr(self::TABULA_RECTA, $cipherCharPosition, 1);
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
            $messageCharPosition = strpos(self::TABULA_RECTA, substr($this->cipherText, $i, 1));
            $keyCharPosition = strpos(self::TABULA_RECTA, substr($this->key, $i, 1));
            
            $shift = $messageCharPosition - $keyCharPosition;
            $plainCharPosition = $shift % strlen(self::TABULA_RECTA);

            $plain .= substr(self::TABULA_RECTA, $plainCharPosition, 1);
        }
        
        $this->setPlainText($plain);
    }
}
