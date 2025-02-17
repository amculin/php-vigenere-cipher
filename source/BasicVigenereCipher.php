<?php
namespace amculin\cryptography\classic;

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
}
