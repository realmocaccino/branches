<?php
namespace App\Console\Commands;

use App\Console\Actions\User\FillLevel;

use Illuminate\Console\Command;

class FillUsersLevelCommand extends Command
{
    protected $signature = 'users:fillLevel';

    protected $description = 'Fill level of all users';

    private $fillUsersLevel;
	
    public function __construct(FillLevel $fillUsersLevel)
    {
        parent::__construct();

        $this->fillUsersLevel = $fillUsersLevel;
    }

    public function handle()
    {
        $this->fillUsersLevel->fill();
    }
}
