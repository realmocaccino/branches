<?php
namespace App\Console\Commands;

use App\Console\Actions\Misc\CacheCategories;

use Illuminate\Console\Command;
use Exception;

class CacheCategoriesCommand extends Command
{
    protected $signature = 'cache:categories';

    protected $description = 'Cache categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(CacheCategories $cacheCategories)
    {
    	try {
        	$cacheCategories->handle();
        	
        	$this->info('Categorias cacheadas com sucesso!');
        } catch(Exception $exception) {
        	$this->error('Cache de categorias falhou! ' . $exception->getMessage());
        }
    }
}