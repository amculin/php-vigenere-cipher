<?php
namespace amculin\cryptography\classic;

use amculin\cryptography\classic\enums\ProcessType;
use amculin\cryptography\classic\exceptions\InvalidBasicException;

/**
 * This file is the main class for basic vigenere cipher algortithm
 *
 * @author Fahmi Auliya Tsani <amixcustomlinux@gmail.com>
 * @version 0.2
 */

class BasicVigenereCipher extends VigenereCipherBlueprint
{
    /**
     * @inheritdoc
     */
    public $tabulaRecta = 'abcdefghijklmnopqrstuvwxyz';

    public function isValid(): bool
    {
        try {
            $pattern = '/^[a-z]*$/';
            $isValid = preg_match($pattern, $this->key);

            if (! $isValid) {
                throw new InvalidBasicException('Key');
            }

            if ($this->process == ProcessType::ENCRYPT->value) {
                $isValid = preg_match($pattern, $this->plainText) && $isValid;

                if (! $isValid) {
                    throw new InvalidBasicException('Plain text');
                }
            } else {
                $isValid = preg_match($pattern, $this->cipherText) && $isValid;

                if (! $isValid) {
                    throw new InvalidBasicException('Cipher text');
                }
            }
        } catch(InvalidBasicException $e) {
            echo $e->errorMessage();

            return false;
        }

        return true;
    }
}
