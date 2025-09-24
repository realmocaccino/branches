<?php
namespace App\Console\Commands;

use App\Console\Exceptions\NoApiGameFoundException;
use App\Console\Actions\Game\FetchModes;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchGameModesCommand extends Command
{
    protected $signature = 'game:fetchModes {gameSlug}';

    protected $description = 'Search for the modes of a game';

    protected $game, $action;

    public function __construct(Game $game, FetchModes $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $this->action->setGame($game = $this->game->findBySlugOrFail($this->argument('gameSlug')));

        try {
            $this->info('Buscando modos de jogo para ' . $game->name);
            $this->action->fetch();
            $this->info('Modos de jogo para ' . $game->name . ' adicionadas com sucesso!');
        } catch(NoApiGameFoundException $exception) {
            $this->error('Não foi possível obter modos de jogo de ' . $game->name);
        }
    }
}