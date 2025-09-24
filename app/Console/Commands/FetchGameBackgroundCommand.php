<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\FetchBackground;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchGameBackgroundCommand extends Command
{
    protected $signature = 'game:fetchBackground {gameSlug}';

    protected $description = 'Fetch a background for a game';

    protected $game;
    protected $action;

    public function __construct(Game $game, FetchBackground $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $game = $this->game->findBySlugOrFail($this->argument('gameSlug'));

        if($this->action->fetch($game)) {
        	$this->info('Background para ' . $game->name . ' salvo com sucesso!');
        } else {
        	$this->error('Não foi possível encontrar um background para ' . $game->name . '.');
        }
    }
}