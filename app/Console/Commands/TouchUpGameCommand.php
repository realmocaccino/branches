<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\TouchUp;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class TouchUpGameCommand extends Command
{
    protected $signature = 'game:touchup {gameSlug}';

    protected $description = 'Enhance and update data of a game.';

    protected $game, $action;

    public function __construct(Game $game, TouchUp $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $game = $this->game->findBySlugOrFail($this->argument('gameSlug'));

        $this->info('Aprimorando dados de ' . $game->name);
        $this->action->handle($game);
        $this->info('Dados de ' . $game->name . ' aprimorados com sucesso!');
    }
}