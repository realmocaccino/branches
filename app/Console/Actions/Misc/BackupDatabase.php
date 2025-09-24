<?php
namespace App\Console\Actions\Misc;

use Symfony\Component\Process\Process;

class BackupDatabase
{
	protected $process;

    public function __construct()
    {
        $this->process = new Process(sprintf(
            'mysqldump -u%s -p%s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            storage_path('backups/database/' . date('YmdHis') . '.sql')
        ));
    }

    public function run()
    {
		$this->process->mustRun();
    }
}