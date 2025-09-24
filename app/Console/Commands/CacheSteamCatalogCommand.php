<?php
namespace App\Console\Commands;

use App\Console\Actions\Misc\CacheSteamCatalog;

use Illuminate\Console\Command;

class CacheSteamCatalogCommand extends Command
{
    protected $signature = 'cache:steam-catalog';

    protected $description = 'Update and cache the Steam Catalog used for registering new games.';

    protected $game, $action;

    public function __construct(CacheSteamCatalog $action)
    {
        parent::__construct();

        $this->action = $action;
    }

    public function handle()
    {
        $this->info('Atualizando catálogo');
        $this->action->run();
        $this->info('Catálogo atualizado com sucesso!');
    }
}