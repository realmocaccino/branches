<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\FetchDescription;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class FetchGameDescriptionCommand extends Command
{
    const DEFAULT_LANGUAGE = 'pt-br';

    protected $signature = 'game:fetchDescription {gameSlug} {language?}';

    protected $description = 'Fetch description for a game';

    protected $game, $action;

    public function __construct(Game $game, FetchDescription $action)
    {
        parent::__construct();

        $this->game = $game;
        $this->action = $action;
    }

    public function handle()
    {
        $this->action->setGame($game = $this->game->findBySlugOrFail($this->argument('gameSlug')));
        $this->action->setLanguage($this->argument('language') ?? self::DEFAULT_LANGUAGE);

        $this->info('Buscando descrição para ' . $game->name);
        if($this->action->fetch()) {
            $this->info('Descrição para ' . $game->name . ' adicionada com sucesso!');
        } else {
            $this->error('Não foi possível atualizar a descrição de ' . $game->name);
        }
    }
}
