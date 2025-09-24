<?php
namespace App\Console\Commands;

use App\Console\Actions\Misc\CacheFeaturedGamesList;

use Illuminate\Console\Command;
use Exception;

class CacheFeaturedGamesListCommand extends Command
{
    protected $signature = 'cache:featured-games-list';

    protected $description = 'Cache featured games list';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(CacheFeaturedGamesList $cacheFeaturedGamesList)
    {
    	try {
        	$cacheFeaturedGamesList->handle();
        	
        	$this->info('Lista de jogos em destaque cacheada com sucesso!');
        } catch(Exception $exception) {
        	$this->error('Cache da lista falhou! ' . $exception->getMessage());
        }
    }
}