<?php
namespace App\Site\Middlewares;

use Closure;

class BlockIp
{
    private $blockedIps = [
        '46.173.6.87',
        '109.163.233.86',
        '37.46.114.115',
        '5.8.16.163',
        '46.20.152.116',
        '85.206.163.145',
        '217.138.193.102',
        '103.224.240.72',
        '85.206.163.149',
        '5.8.16.149',
        '195.181.167.194',
        '45.83.90.148',
        '161.97.131.33'
    ];

    public function handle($request, Closure $next)
    {
        if(in_array($request->ip(), $this->blockedIps)) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}