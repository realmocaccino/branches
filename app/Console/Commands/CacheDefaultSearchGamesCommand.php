<?php
namespace App\Console\Commands;

use App\Site\Services\DefaultSearchGamesService;

use Illuminate\Console\Command;
use Exception;

class CacheDefaultSearchGamesCommand extends Command
{
    protected $signature = 'cache:default-search-games';

    protected $description = 'Cache default search games';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(DefaultSearchGamesService $defaultSearchGamesService)
    {
    	try {
        	$defaultSearchGamesService->cache();
        	
        	$this->info('Lista de jogos iniciais na busca cacheada com sucesso!');
        } catch(Exception $exception) {
        	$this->error('Cache da lista falhou! ' . $exception->getMessage());
        }
    }
}