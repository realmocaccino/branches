<?php
namespace App\Site\Controllers;

use App\Site\Controllers\BaseController;
use App\Site\Helpers\AddGameHelper;
use App\Site\Jobs\CreateGameJob;
use App\Site\Requests\AddGameRequest;
use App\Site\Requests\Add\SearchRequest;
use App\Common\Deciders\GameNameDecider;
use App\Common\DTOs\GameDto;
use App\Common\Factories\GameFactory;

use Illuminate\Support\Facades\Auth;

class AddGameController extends BaseController
{
	protected const TOTAL_GAMES_TO_CHOOSE = 4;

    protected $addGameHelper;
    protected $gameFactory;
	protected $gameNameDecider;

	protected $user;

	public function __construct(
		AddGameHelper $addGameHelper,
		GameFactory $gameFactory,
		GameNameDecider $gameNameDecider,
	) {
		parent::__construct();

        $this->addGameHelper = $addGameHelper;
        $this->gameFactory = $gameFactory;
		$this->gameNameDecider = $gameNameDecider;
		
		$this->middleware(function($request, $next) {
			$this->user = Auth::guard('site')->user();
			return $next($request);
		});
	}

	public function index()
	{
		$this->head->setTitle(trans('add/game/index.title'));
		$this->head->setDescription(trans('add/game/index.description') . $this->settings->name);

		return $this->view('add.game.index', [
			'characteristics' => $this->addGameHelper->getCharacteristics(),
			'developers' => $this->addGameHelper->getDevelopers(),
			'franchises' => $this->addGameHelper->getFranchises(),
			'genres' => $this->addGameHelper->getGenres(),
			'modes' => $this->addGameHelper->getModes(),
			'platforms' => $this->addGameHelper->getPlatforms(),
			'publishers' => $this->addGameHelper->getPublishers(),
			'themes' => $this->addGameHelper->getThemes()
		]);
	}

    public function save(AddGameRequest $request)
    {
		if($existingGame = $this->gameNameDecider->exists($request->name, $request->release)) {
            return redirect()->route('game.index', $existingGame->slug)->with('alert', 'info|' . $request->name . ' já existe em nosso catálogo.');
        }

        $game = $this->gameFactory->create(new GameDTO($request), $this->user);

		$this->addGameHelper->filterTags($game);
		
		if($request->new_developer_name) {
			$this->addGameHelper->saveNewDeveloperAndPublisher(
				$game,
				$request->new_developer_name,
				$request->create_publisher_with_same_name
			);
		}

        return redirect()->route('game.index', [$game->slug])->with('alert', 'success|Jogo incluído no catálogo com sucesso.');
    }
	
	public function search()
	{
		$this->head->setTitle(trans('add/game/index.title'));
		$this->head->setDescription(trans('add/game/index.description') . $this->settings->name);

		return $this->view('add.game.search');
	}

    public function choose(SearchRequest $request)
    {
		$this->head->setTitle(trans('add/game/index.title'));
		$this->head->setDescription(trans('add/game/index.description') . $this->settings->name);

		$vendor = CreateGameJob::GIANT_BOMB_VENDOR_TERM;
		$apiGames = $this->addGameHelper->getGamesFromGiantBomb($request->name, self::TOTAL_GAMES_TO_CHOOSE);

		if(!$this->addGameHelper->isGameInTheResults($apiGames, $request->name)) {
			$vendor = CreateGameJob::STEAM_VENDOR_TERM;
			$apiGames = $this->addGameHelper->getGamesFromSteam($request->name, self::TOTAL_GAMES_TO_CHOOSE);
		}

        if(!$apiGames) {
            return redirect()->route('add.game.search')->withInput()->with('alert', 'info|' . trans('add/game/choose.no_results'));
        }

        return $this->view('add.game.choose', [
            'name' => $request->name,
            'apiGames' => $apiGames,
			'vendor' => $vendor
        ]);
    }
	
	public function queue($vendor, $apiGameId)
	{
        CreateGameJob::dispatch($vendor, $apiGameId, $this->user);

        return redirect()->route('home')->with('alert', 'info|Cadastrando jogo. Aguarde notificação!|false');
	}
}
