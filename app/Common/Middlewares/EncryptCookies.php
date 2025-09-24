<?php
namespace App\Common\Middlewares;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    protected $except = [
        //
    ];
}
