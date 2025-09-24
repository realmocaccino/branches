<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\TouchUp;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class TouchUpUpcomingGamesCommand extends Command
{
    protected $signature = 'games:touchupUpcomingGames';

    protected $description = 'Enhance and update data of upcoming games.';

    protected $game, $action;

    public function __construct(Game $game, TouchUp $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $upcomingGames = $this->game->where('games.release', '>', today())->orWhereNull('games.release')->get();

        foreach ($upcomingGames as $game) {
            $this->info('Aprimorando dados de ' . $game->name);
            $this->action->handle($game);
            $this->info('Dados de ' . $game->name . ' aprimorados com sucesso!');
        }
    }
}