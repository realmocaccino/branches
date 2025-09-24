<?php
namespace App\Console\Commands;

use App\Common\Exceptions\GameAlreadyExistsException;
use App\Console\Exceptions\{
    ApiNoResponseException,
    NoApiGameFoundException,
    NoApiGameSetException
};
use App\Console\Helpers\{GiantBombHelper, IgdbHelper, SteamHelper};
use App\Console\Actions\Game\FetchGame;
use App\Site\Helpers\Site;

use Illuminate\Console\Command;

class CrawlGameCommand extends Command
{
    private const TOTAL_GAMES_TO_SEARCH = 4;

    protected $signature = 'game:crawl {--no-publish}';

    protected $description = 'Crawl and create a game';

    private $giantBombHelper;
    private $igdbHelper;
    private $steamHelper;

    public function __construct(GiantBombHelper $giantBombHelper, IgdbHelper $igdbHelper, SteamHelper $steamHelper)
    {
        parent::__construct();

        $this->giantBombHelper = $giantBombHelper;
        $this->igdbHelper = $igdbHelper;
        $this->steamHelper = $steamHelper;
    }

    public function handle(FetchGame $action)
    {
        $term = $this->ask('Qual o nome do jogo?');

        try {
            $action->setSteamGame($this->promptOptions($term, $this->steamHelper, 'Escolha o jogo da Steam'));
        } catch(ApiNoResponseException|NoApiGameFoundException $exception) {
            $this->info('Nenhuma opção disponível na Steam');
        }

        try {
            $action->setGiantBombGame($this->promptOptions($term, $this->giantBombHelper, 'Escolha o jogo da Giant Bomb'));
        } catch(ApiNoResponseException|NoApiGameFoundException $exception) {
            $this->info('Nenhuma opção disponível no Giant Bomb');
        }

        try {
            $action->setIgdbGame($this->promptOptions($term, $this->igdbHelper, 'Escolha o jogo da IGDB'));
        } catch(ApiNoResponseException|NoApiGameFoundException $exception) {
            $this->info('Nenhuma opção disponível no IGDB');
        }

        try {
            $action->setUserWhoContributed(Site::getOfficialUser())->create(!$this->option('no-publish'));
            $this->info($this->getMessage($action->game->slug));
        } catch(GameAlreadyExistsException|NoApiGameSetException $exception) {
            exit($exception->getMessage());
        }
        
        $action->setAdditionalData($console = $this);
    }

    private function getMessage($gameSlug)
    {
        return 'Jogo criado' . ($this->option('no-publish') ? '!' : ' e publicado! (' . route('game.index', $gameSlug) . ')');
    }

    private function promptOptions($term, $helper, $question)
    {
        $options = $helper->provideGamesToChoose($term, self::TOTAL_GAMES_TO_SEARCH);

        if(!$options) {
            throw new NoApiGameFoundException();
        }

        return $this->getIdFromChosenOption($options, $this->choice($question, array_map(function($option) {
            return $option->nameWithReleaseYear;
        }, $options)));
    }

    private function getIdFromChosenOption($options, $chosenOption)
    {
        $idNamePair = array_combine(
            array_column($options, 'id'),
            array_column($options, 'nameWithReleaseYear')
        );

        return array_search($chosenOption, $idNamePair);
    }
}