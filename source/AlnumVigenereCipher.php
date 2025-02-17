<?php
namespace amculin\cryptography\classic;

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
}
