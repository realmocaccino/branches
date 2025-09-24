<?php
namespace App\Console\Commands;

use App\Console\Exceptions\{GameHasNoPlatformException, GameHasNoPlatformOnMetacriticException};
use App\Console\Actions\Game\FetchCriticScore;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchGameCriticScoreCommand extends Command
{
    protected $signature = 'game:fetchCriticScore {gameSlug} {url?}';

    protected $description = 'Fetch critic score for a game';

    protected $game, $action;

    public function __construct(Game $game, FetchCriticScore $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $this->action->setGame($game = $this->game->findBySlugOrFail($this->argument('gameSlug')));

        if($url = $this->argument('url')) {
            $this->action->setUrl($url);
        }

        $this->info('Buscando nota da crítica para ' . $game->name);
        try {
            if($this->action->fetch()) {
                $this->info('Nota para ' . $game->name . ' adicionada com sucesso!');
            } else {
                $this->error('Não foi possível atualizar a nota de ' . $game->name);
            }
        } catch(GameHasNoPlatformException|GameHasNoPlatformOnMetacriticException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
