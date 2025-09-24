<?php
namespace App\Console\Commands;

use App\Console\Actions\Misc\BackupDatabase;

use Illuminate\Console\Command;
use Exception;

class BackupDatabaseCommand extends Command
{
    protected $signature = 'db:backup';

    protected $description = 'Backup the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
    	try {
        	(new BackupDatabase)->run();
        	
        	$this->info('Backup realizado com sucesso!');
        } catch(Exception $exception) {
        	$this->error('Backup falhou!');
        }
    }
}
