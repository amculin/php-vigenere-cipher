<?php

use PHPUnit\Framework\TestCase;
use amculin\cryptography\classic\VigenereCipher;
use amculin\cryptography\classic\enums\VigenereMode;

final class VigenereCipherTest extends TestCase
{
    public function testCanEncryptWithBasicMode():void
    {
        $allowedChars = '/[a-z]/';
        $data = 'encryptionprocess';
        $key = 'thekey';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals(strlen($data), strlen($encrypted));
        $this->assertEquals('xugbcnmpsxtphjicw', $encrypted);
        $this->assertNotEquals($data, $encrypted);
        $this->assertIsString($data);
        $this->assertIsString($key);
        $this->assertIsString($encrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $encrypted);
    }

    public function testCanDecryptWithBasicMode():void
    {
        $allowedChars = '/[a-z]/';
        $data = 'xugbcnmpsxtphjicw';
        $key = 'thekey';

        $decrypted = VigenereCipher::decrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals(strlen($data), strlen($decrypted));
        $this->assertEquals('encryptionprocess', $decrypted);
        $this->assertNotEquals($data, $decrypted);
        $this->assertIsString($data);
        $this->assertIsString($key);
        $this->assertIsString($decrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $decrypted);
    }

    public function testCanEncryptWithAlphaNumericMode():void
    {
        $allowedChars = '/[a-zA-Z0-9]/';
        $data = 'Encrypti0nProC3s5';
        $key = 'th3kEy';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::ALPHA_NUMERIC->value);

        $this->assertEquals(strlen($data), strlen($encrypted));
        $this->assertEquals('Xu5B2NMpTxjPHJWCz', $encrypted);
        $this->assertNotEquals($data, $encrypted);
        $this->assertIsString($data);
        $this->assertIsString($key);
        $this->assertIsString($encrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $encrypted);
    }

    public function testCanDecryptWithAlphaNumericMode():void
    {
        $allowedChars = '/[a-zA-Z0-9]/';
        $data = 'Xu5B2NMpTxjPHJWCz';
        $key = 'th3kEy';

        $decrypted = VigenereCipher::decrypt($data, $key, VigenereMode::ALPHA_NUMERIC->value);

        $this->assertEquals(strlen($data), strlen($decrypted));
        $this->assertEquals('Encrypti0nProC3s5', $decrypted);
        $this->assertNotEquals($data, $decrypted);
        $this->assertIsString($data);
        $this->assertIsString($key);
        $this->assertIsString($decrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $decrypted);
    }

    public function testCanGetBasicVigenereClass(): void
    {
        $path = 'amculin\cryptography\classic\\';
        $mode = VigenereMode::BASIC->value;

        $className = VigenereCipher::getClassName($mode);

        $this->assertIsString($className);
        $this->assertEquals($path . 'BasicVigenereCipher', $className);
    }

    public function testCanGetAlphaNumericVigenereClass(): void
    {
        $path = 'amculin\cryptography\classic\\';
        $mode = VigenereMode::ALPHA_NUMERIC->value;

        $className = VigenereCipher::getClassName($mode);

        $this->assertIsString($className);
        $this->assertEquals($path . 'AlnumVigenereCipher', $className);
    }
}
