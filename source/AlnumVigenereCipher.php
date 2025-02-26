<?php
namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\exceptions\InvalidAlnumException;

/**
 * This file is the main class for alpha-numric mode vigenere cipher algortithm
 *
 * @author Fahmi Auliya Tsani <amixcustomlinux@gmail.com>
 * @version 0.1
 */

class AlnumVigenereCipher extends VigenereCipherBlueprint
{
    /**
     * Default list of acceptable character to be used in vigenere cipher algorithm
     * This list cointains alpha-numeric characters including the capitalized
     *
     * @var string
     */
    public $tabulaRecta = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    public function isValid(): bool
    {
        try {
            $pattern = '/^[a-zA-Z0-9]*$/';
            $isValid = preg_match($pattern, $this->key);

            if (! $isValid) {
                throw new InvalidAlnumException('Key');
            }

            if ($this->process == ProcessType::ENCRYPT->value) {
                $isValid = preg_match($pattern, $this->plainText) && $isValid;

                if (! $isValid) {
                    throw new InvalidAlnumException('Plain text');
                }
            } else {
                $isValid = preg_match($pattern, $this->cipherText) && $isValid;

                if (! $isValid) {
                    throw new InvalidAlnumException('Cipher text');
                }
            }
        } catch(InvalidAlnumException $e) {
            echo $e->errorMessage();

            return false;
        }

        return true;
    }
}
