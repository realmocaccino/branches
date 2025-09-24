<?php
namespace App\Console\Actions\Misc;

use Symfony\Component\Process\Process;

class FlushCacheDirectory
{
    private const PATH = '/var/www/html/notadogame.com/storage/framework/cache/data/*';

    private $process;

    public function __construct()
    {
        $this->process = new Process('rm -rf ' . self::PATH);
    }

    public function run()
    {
		$this->process->mustRun();
    }
}
