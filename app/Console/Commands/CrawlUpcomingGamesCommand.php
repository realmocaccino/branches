<?php
namespace App\Console\Commands;

use App\Common\Exceptions\GameAlreadyExistsException;
use App\Common\Helpers\Support;
use App\Console\Exceptions\NoApiGameSetException;
use App\Console\Helpers\GiantBombHelper;
use App\Console\Actions\Game\FetchGame;
use App\Site\Helpers\Site;
use App\Site\Models\Game;

use Illuminate\Console\Command;

class CrawlUpcomingGamesCommand extends Command
{
    protected $signature = 'games:crawlUpcomingGames {--dont-ask}';

    protected $description = 'Search for upcoming games';

    protected $helper;

    public function __construct(GiantBombHelper $giantBombHelper)
    {
        parent::__construct();
        
        $this->helper = $giantBombHelper;
    }

    public function handle(FetchGame $action)
    {
        if($games = $this->getUpcomingGamesThatAreNotInTheCatalogYet()) {
        	foreach($games as $game) {
        		if($this->askOrProceed($game)) {
                    if($this->option('dont-ask')) {
                        $this->info('Creating ' . $game->name);
                    }

					$action->setGiantBombGame($game->id);

                    try {
                        $action
                        ->guessIgdbGame()
                        ->guessSteamGame()
                        ->setUserWhoContributed(Site::getOfficialUser())
                        ->create();
                        $this->info('Jogo criado e publicado! (' . route('game.index', $action->game->slug) . ')');
                    } catch(GameAlreadyExistsException|NoApiGameSetException $exception) {
                        if(!$this->option('dont-ask')) {
                            exit($exception->getMessage());
                        }
                    }

                    $action->setAdditionalData($console = $this->option('dont-ask') ? null : $this)->clear();
        		}
        	}
        } else {
            $this->info('Nenhum novo jogo a cadastrar!');
        }
    }

    private function askOrProceed($game)
    {
        $yearInfo = property_exists($game, 'first_release_date') ? ' (' . Support::milisecondsToDate($game->first_release_date, 'd/m/Y') . ')' : null;

        return $this->option('dont-ask') or $this->confirm('Deseja criar o jogo ' . $game->name . $yearInfo);
    }

    private function getUpcomingGamesThatAreNotInTheCatalogYet()
    {
        return array_filter($this->helper->getUpcomingGames(), function($game) {
            return !Game::whereName($game->name)->withTrashed()->exists();
        });
    }
}