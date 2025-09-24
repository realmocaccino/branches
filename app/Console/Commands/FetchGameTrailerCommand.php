<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\FetchTrailer;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchGameTrailerCommand extends Command
{
    protected $signature = 'game:fetchTrailer {gameSlug} {url?}';

    protected $description = 'Fetch release trailer for a game';

    protected $game, $action;

    public function __construct(Game $game, FetchTrailer $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $this->action
            ->setGame($game = $this->game->findBySlugOrFail($this->argument('gameSlug')))
            ->setUrl($this->argument('url'));

        $this->info('Buscando trailer para ' . $game->name);
        if($this->action->fetch()) {
            $this->info('Trailer para ' . $game->name . ' adicionado com sucesso!');
        } else {
            $this->error('Não foi possível atualizar o trailer de ' . $game->name);
        }
    }
}
