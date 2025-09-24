<?php
namespace App\Console\Jobs;

use App\Console\Actions\Misc\CustomRoutines;

class CustomRoutinesJob
{
    public function handle(CustomRoutines $action)
    {
        $action->handle();
    }
}