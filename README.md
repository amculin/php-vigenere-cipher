<h1 align="center"><b>Implementation of Vigenere Cipher in PHP</b></h1>
<p align="center">
  <img src="https://img.shields.io/packagist/dt/amculin/vigenere-cipher" alt="Packagist Download" />
  <img src="https://img.shields.io/github/stars/amculin/php-vigenere-cipher" alt="GitHub Repo stars" />
  <img src="https://img.shields.io/packagist/v/amculin/vigenere-cipher" alt="Packagist Version" />
  <img src="https://img.shields.io/github/actions/workflow/status/amculin/php-vigenere-cipher/build.yml" alt="Passed Build Workflow" />
  <img src="https://img.shields.io/badge/PHPStan-L_10-blue" alt="Passed PHPStan Level 10" />
</p>

Encrypt/decrypt string using Vigenere Cipher algorithm
## Instalation
```bash
composer require amculin/vigenere-cipher
```
## How to use
Encryption
```php
use amculin\cryptography\classic\VigenereCipher;

$data = 'testtheencryptionprocess';
$key = 'thisisthekey';

//Basic mode only support lowercase alphabet
//You can use alpha_numeric mode for wider supported characters (a-z, A-Z, 0-9)
$encrypted = VigenereCipher::encrypt($data, $key, 'basic');

echo "Plain text: {$data}\n";
echo "Key: {$key}\n";
echo "Cipher Text: {$encrypted}\n";
```
Output:
```bash
Plain text: testtheencryptionprocess
Key: thisisthekey
Cipher Text: mlalbzxlrmvwiaqgvhkvgowq
```

Decryption
```php
use amculin\cryptography\classic\VigenereCipher;

$data = 'mlalbzxlrmvwiaqgvhkvgowq';
$key = 'thisisthekey';
$decrypted = VigenereCipher::decrypt($data, $key, 'basic');

echo "Cipher text: {$data}\n";
echo "Key: {$key}\n";
echo "Plain Text: {$decrypted}\n";
```
Output:
```bash
Cipher Text: mlalbzxlrmvwiaqgvhkvgowq
Key: thisisthekey
Plain text: testtheencryptionprocess
```

## Features
- [x] Support basic mode/lowercase alphabet only
- [x] Support alpha-numeric mode (a-z, A-Z, 0-9)
- [x] Unit test
- [x] Comply PHPStan Level 10

## Todos
- [ ] Add ASCII mode to support file encryption/decryption
- [ ] Add Base64 mode to support Base64 string
