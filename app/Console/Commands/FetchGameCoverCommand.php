<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\FetchCover;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchGameCoverCommand extends Command
{
    protected $signature = 'game:fetchCover {gameSlug}';

    protected $description = 'Get the cover and attach it to a game';

    protected $game, $action;

    public function __construct(Game $game, FetchCover $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $game = $this->game->findBySlugOrFail($this->argument('gameSlug'));

        $this->info('Buscando cover');
        if($this->action->fetch($game)) {
            $this->info('Cover encontrado e salvo');
        } else {
            $this->error('Cover não encontrado');
        }
    }
}