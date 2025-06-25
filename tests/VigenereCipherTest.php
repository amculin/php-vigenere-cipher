<?php

use amculin\cryptography\classic\enums\VigenereMode;
use amculin\cryptography\classic\VigenereCipher;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class VigenereCipherTest extends TestCase
{
    public const BASIC_ALLOWED_CHARS = '/[a-z]/';
    public const ALNUM_ALLOWED_CHARS = '/[a-zA-Z0-9]/';
    public const BASE64_ALLOWED_CHARS = '/[A-Za-z0-9+\/=]/';

    public function testCanEncryptInBasicMode(): void
    {
        $allowedChars = $this::BASIC_ALLOWED_CHARS;
        $data = 'encryptionprocess';
        $key = 'thekey';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals(strlen($data), strlen($encrypted));
        $this->assertEquals('xugbcnmpsxtphjicw', $encrypted);
        $this->assertNotEquals($data, $encrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $encrypted);
    }

    public function testCanNotEncryptInBasicModeWithInvalidKey(): void
    {
        $data = 'encryptionprocess';
        $key = 'thekey-';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals('', $encrypted);
    }

    public function testCanDecryptInBasicMode(): void
    {
        $allowedChars = $this::BASIC_ALLOWED_CHARS;
        $data = 'xugbcnmpsxtphjicw';
        $key = 'thekey';

        $decrypted = VigenereCipher::decrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals(strlen($data), strlen($decrypted));
        $this->assertEquals('encryptionprocess', $decrypted);
        $this->assertNotEquals($data, $decrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $decrypted);
    }

    public function testCanNotDecryptInBasicModeWithInvalidKey(): void
    {
        $data = 'xugbcnmpsxtphjicw';
        $key = 'thekey-';

        $decrypted = VigenereCipher::decrypt($data, $key, VigenereMode::BASIC->value);

        $this->assertEquals('', $decrypted);
    }

    public function testCanEncryptInAlphaNumericMode(): void
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

    public function testCanNotEncryptInAlphaNumericModeWithInvalidKey(): void
    {
        $data = 'Encrypti0nProC3s5';
        $key = 'th3kEy-';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::ALPHA_NUMERIC->value);

        $this->assertEquals('', $encrypted);
    }

    public function testCanDecryptWithAlphaNumericMode(): void
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

    public function testCanNotDecryptInAlphaNumericModeWithInvalidKey(): void
    {
        $data = 'Xu5B2NMpTxjPHJWCz';
        $key = 'th3kEy-';

        $decrypted = VigenereCipher::decrypt($data, $key, VigenereMode::ALPHA_NUMERIC->value);

        $this->assertEquals('', $decrypted);
    }

    public function testCanEncryptInBase64Mode(): void
    {
        $allowedChars = $this::BASE64_ALLOWED_CHARS;
        $data = 'RW5jcnlwdGkwblByb0MzczU=';
        $key = 'th3kEy';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::BASE64->value);

        $this->assertEquals(strlen($data), strlen($encrypted));
        $this->assertEquals('+3vGgYRQTqohHF4Vfl5TSWYx', $encrypted);
        $this->assertNotEquals($data, $encrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $encrypted);
    }

    public function testCanNotEncryptInBase64ModeWithInvalidKey(): void
    {
        $data = 'RW5jcnlwdGkwblByb0MzczU=';
        $key = 'th3kEy-';

        $encrypted = VigenereCipher::encrypt($data, $key, VigenereMode::BASE64->value);

        $this->assertEquals('', $encrypted);
    }

    public function testCanDecryptWithBase64Mode(): void
    {
        $allowedChars = $this::ALNUM_ALLOWED_CHARS;
        $data = '+3vGgYRQTqohHF4Vfl5TSWYx';
        $key = 'th3kEy';

        $decrypted = VigenereCipher::decrypt($data, $key, VigenereMode::BASE64->value);

        $this->assertEquals(strlen($data), strlen($decrypted));
        $this->assertEquals('RW5jcnlwdGkwblByb0MzczU=', $decrypted);
        $this->assertNotEquals($data, $decrypted);
        $this->assertMatchesRegularExpression($allowedChars, $data);
        $this->assertMatchesRegularExpression($allowedChars, $key);
        $this->assertMatchesRegularExpression($allowedChars, $decrypted);
    }

    public function testCanNotDecryptInBase64ModeWithInvalidKey(): void
    {
        $data = '+3vGgYRQTqohHF4Vfl5TSWYx';
        $key = 'th3kEy-';

        $decrypted = VigenereCipher::decrypt($data, $key, VigenereMode::BASE64->value);

        $this->assertEquals('', $decrypted);
    }
}
