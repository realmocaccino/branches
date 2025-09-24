<?php
namespace App\Common\Middlewares;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    protected $except = [
        'ajax/pesquisa',
        'find'
    ];
}
