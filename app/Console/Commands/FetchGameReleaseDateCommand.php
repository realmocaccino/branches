<?php
namespace App\Console\Commands;

use App\Site\Models\Game;
use App\Console\Exceptions\ReleaseDateNotFoundException;
use App\Console\Actions\Game\FetchReleaseDate;

use Illuminate\Console\Command;

class FetchGameReleaseDateCommand extends Command
{
    protected $signature = 'game:fetchReleaseDate {gameSlug} {--force}';

    protected $description = 'Search for release date of a game';

    protected $game;
    protected $action;

    public function __construct(Game $game, FetchReleaseDate $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        try {
            $game = $this->game->findBySlugOrFail($this->argument('gameSlug'));

            $this->info('Buscando data de lançamento de ' . $game->name);

            $this->action->setGame($game)->crawl();

            if($this->action->getDate() and
            (
                $this->option('force') or
                $this->confirm('Confirma a data de lançamento de ' . $this->action->getDate('d/m/Y') . ' para ' . $game->name)
            )
            ) {
                $this->action->save();
                $this->info('Data de lançamento salva');
            }
        } catch(ReleaseDateNotFoundException $exception) {
            $this->info($exception->getMessage());
        }
    }
}
