<?php
namespace amculin\cryptography\classic\enums;

enum VigenereMode: string {
    case BASIC = 'basic';
    case ALPHA_NUMERIC = 'alpha_numeric';
    case BASE64 = 'base64';
    case ASCII = 'ascii';
}
