<?php
namespace App\Console\Commands;

use App\Console\Exceptions\NoApiGameFoundException;
use App\Console\Actions\Game\FetchTags;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchGameTagsCommand extends Command
{
    protected $signature = 'game:fetchTags {gameSlug}';

    protected $description = 'Search for genre, theme and characteristics of a game';

    protected $game, $action;

    public function __construct(Game $game, FetchTags $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $this->action->setGame($game = $this->game->findBySlugOrFail($this->argument('gameSlug')));

        try {
            $this->info('Buscando tags para ' . $game->name);
            $this->action->fetchThenSyncAll()->filter();
            $this->info('Tags para ' . $game->name . ' adicionadas com sucesso!');
        } catch(NoApiGameFoundException $exception) {
            $this->error('Não foi possível obter tags de ' . $game->name);
        }
    }
}