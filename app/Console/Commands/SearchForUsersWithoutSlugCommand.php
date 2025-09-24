<?php
namespace App\Console\Commands;

use App\Console\Actions\User\FillSlugToUsersWithoutOne;

use Illuminate\Console\Command;

class SearchForUsersWithoutSlugCommand extends Command
{
    protected $signature = 'users:searchForUsersWithoutSlug';

    protected $description = 'Fill slug to users who don\'t have one';
	
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new FillSlugToUsersWithoutOne();
        $action->fill();
    }
}
