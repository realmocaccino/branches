<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\FetchScreenshots;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchGameScreenshotsCommand extends Command
{
    protected $signature = 'game:fetchScreenshots {gameSlug}';

    protected $description = 'Fetch screenshots for a game';

    protected $game;
    protected $action;
    protected $renew = false;

    public function __construct(Game $game, FetchScreenshots $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $game = $this->game->findBySlugOrFail($this->argument('gameSlug'));

        $this->checkIfGameAlreadyHasScreenshots($game);

        if($this->action->fetch($game, $this->renew)) {
        	$this->info('Capturas de tela de ' . $game->name . ' anexadas com sucesso!');
        } else {
        	$this->error('Não foi possível anexar as capturas de tela de ' . $game->name . '.');
        }
    }

    private function checkIfGameAlreadyHasScreenshots(Game $game)
    {
        if($game->screenshots->count()) {
            if($this->confirm($game->name . ' já possui capturas de tela. Deseja renovar?')) {
                $this->renew = true;
            } else {
                exit();
            }
        }
    }
}