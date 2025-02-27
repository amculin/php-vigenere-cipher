<?php

use PHPUnit\Framework\TestCase;
use amculin\cryptography\classic\VigenereCipher;
use amculin\cryptography\classic\enums\VigenereMode;

final class VigenereCipherTest extends TestCase
{
    const BASIC_ALLOWED_CHARS = '/[a-z]/';
    const ALNUM_ALLOWED_CHARS = '/[a-zA-Z0-9]/';

    public function testCanEncryptInBasicMode():void
    {
        $allowedChars = $this::BASIC_ALLOWED_CHARS;
        $data = 'encryptionprocess';
        $key = 'thekey';

        $encrypted = (string) VigenereCipher::encrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals(strlen($data), strlen($encrypted));
        $this->assertEquals('xugbcnmpsxtphjicw', $encrypted);
        $this->assertNotEquals($data, $encrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $encrypted);
    }

    public function testCanNotEncryptInBasicModeWithInvalidKey():void
    {
        $data = 'encryptionprocess';
        $key = 'thekey-';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals('', $encrypted);
    }

    public function testCanDecryptInBasicMode():void
    {
        $allowedChars = $this::BASIC_ALLOWED_CHARS;
        $data = 'xugbcnmpsxtphjicw';
        $key = 'thekey';

        $decrypted = (string) VigenereCipher::decrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals(strlen($data), strlen($decrypted));
        $this->assertEquals('encryptionprocess', $decrypted);
        $this->assertNotEquals($data, $decrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $decrypted);
    }

    public function testCanNotDecryptInBasicModeWithInvalidKey():void
    {
        $data = 'xugbcnmpsxtphjicw';
        $key = 'thekey-';

        $encrypted = VigenereCipher::decrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals('', $encrypted);
    }

    public function testCanEncryptInAlphaNumericMode():void
    {
        $allowedChars = $this::ALNUM_ALLOWED_CHARS;
        $data = 'Encrypti0nProC3s5';
        $key = 'th3kEy';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::ALPHA_NUMERIC->value);

        $this->assertEquals(strlen($data), strlen($encrypted));
        $this->assertEquals('Xu5B2NMpTxjPHJWCz', $encrypted);
        $this->assertNotEquals($data, $encrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $encrypted);
    }

    public function testCanNotEncryptInAlphaNumericModeWithInvalidKey():void
    {
        $data = 'Encrypti0nProC3s5';
        $key = 'th3kEy-';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::ALPHA_NUMERIC->value);

        $this->assertEquals('', $encrypted);
    }

    public function testCanDecryptWithAlphaNumericMode():void
    {
        $allowedChars = $this::ALNUM_ALLOWED_CHARS;
        $data = 'Xu5B2NMpTxjPHJWCz';
        $key = 'th3kEy';

        $decrypted = VigenereCipher::decrypt($data, $key, VigenereMode::ALPHA_NUMERIC->value);

        $this->assertEquals(strlen($data), strlen($decrypted));
        $this->assertEquals('Encrypti0nProC3s5', $decrypted);
        $this->assertNotEquals($data, $decrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $decrypted);
    }

    public function testCanNotDecryptInAlphaNumericModeWithInvalidKey():void
    {
        $data = 'Xu5B2NMpTxjPHJWCz';
        $key = 'th3kEy-';

        $encrypted = VigenereCipher::decrypt($data, $key, VigenereMode::ALPHA_NUMERIC->value);

        $this->assertEquals('', $encrypted);
    }

    public function testCanGetBasicVigenereClass(): void
    {
        $path = 'amculin\cryptography\classic\\';
        $mode = VigenereMode::BASIC->value;

        $className = VigenereCipher::getClassName($mode);

        $this->assertEquals($path . 'BasicVigenereCipher', $className);
    }

    public function testCanGetAlphaNumericVigenereClass(): void
    {
        $path = 'amculin\cryptography\classic\\';
        $mode = VigenereMode::ALPHA_NUMERIC->value;

        $className = VigenereCipher::getClassName($mode);

        $this->assertEquals($path . 'AlnumVigenereCipher', $className);
    }
}
