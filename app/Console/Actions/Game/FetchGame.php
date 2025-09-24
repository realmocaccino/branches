<?php
namespace App\Console\Actions\Game;

use App\Site\Models\{Characteristic, Classification, Developer, Franchise, Genre, Mode, Platform, Publisher, Theme, User};
use App\Common\Deciders\GameNameDecider;
use App\Common\DTOs\GameDto;
use App\Common\Exceptions\GameAlreadyExistsException;
use App\Common\Factories\GameFactory;
use App\Common\Helpers\Support;
use App\Console\Exceptions\{ApiNoResponseException, NoApiGameSetException};
use App\Console\Helpers\{GiantBombHelper, IgdbHelper, SteamHelper, TranslaterHelper};
use App\Console\Actions\Game\Traits\SetAdditionalData;

class FetchGame
{
    public $game;
    public $giantBombGame;
    public $igdbGame;
    public $steamGame;
    public $user = null;

    protected $fetchCriticScore;
    protected $fetchReleaseDate;
    protected $fetchTags;
    protected $fetchTrailer;
    protected $gameFactory;
    protected $gameNameDecider;
	protected $giantBombHelper;
    protected $igdbHelper;
    protected $steamHelper;
    protected $translaterHelper;

    protected $developersToInsert = [];
    protected $franchisesToInsert = [];
    protected $publishersToInsert = [];

    protected $giantBombFields = [
    	'name',
    	'aliases',
    	'deck',
    	'releases',
    	'expected_release_day',
    	'expected_release_month',
    	'expected_release_year',
    	'original_release_date',
    	'image',
    	'images',
    	'developers',
    	'franchises',
    	'genres',
    	'platforms',
    	'publishers',
    	'releases',
    	'themes'
    ];
    
    protected $igdbFields = [
        'name',
        'summary',
    	'cover.url',
    	'game_modes.name',
    	'multiplayer_modes.onlinecoop',
    	'multiplayer_modes.offlinecoop',
    	'screenshots.url'
    ];

    protected $steamFields = [
        'classification',
        'cover',
        'description',
        'developers',
        'modes',
        'name',
        'platforms',
        'publishers',
        'release_date',
        'screenshots'
    ];

    const ALIAS_SEPARATOR = ', ';
    const GENRES_WITHOUT_CAMPAIGN = [
        'Sport',
        'Racing'
    ];
    const LANGUAGE_TO_TRANSLATE = 'pt-br';
    const LEGAL_ABBREVIATIONS = [', inc.', 'LLC', 'GmbH', 'Co. Ltd.'];
    const MINIMUM_CHARACTERS_RELEVANT_DESCRIPTION = 30;
    const MINIMUM_CHARACTERS_TO_REMOVE_LEGAL_ABBREVIATIONS = 12;
    const NO_API_GAME_SET_MESSAGE = 'Nenhum jogo de API foi setado';
    const STEAM_LANGUAGE = 'pt-br';
    const TOTAL_GAMES_TO_SEARCH_WHEN_GUESSING = 4;
    const TOTAL_SCREENSHOTS = 20;

    public function __construct(
        FetchCriticScore $fetchCriticScore,
        FetchReleaseDate $fetchReleaseDate,
        FetchTags $fetchTags,
        FetchTrailer $fetchTrailer,
        GameFactory $gameFactory,
        GameNameDecider $gameNameDecider,
        GiantBombHelper $giantBombHelper,
        IgdbHelper $igdbHelper,
        SteamHelper $steamHelper,
        TranslaterHelper $translaterHelper
    ) {
        $this->fetchCriticScore = $fetchCriticScore;
        $this->fetchReleaseDate = $fetchReleaseDate;
        $this->fetchTags = $fetchTags;
        $this->fetchTrailer = $fetchTrailer;
        $this->gameFactory = $gameFactory;
        $this->gameNameDecider = $gameNameDecider;
        $this->giantBombHelper = $giantBombHelper;
        $this->igdbHelper = $igdbHelper;
        $this->steamHelper = $steamHelper;
        $this->translaterHelper = $translaterHelper;
    }

    public function clear()
    {
        $this->game = null;
        $this->giantBombGame = null;
        $this->igdbGame = null;
        $this->steamGame = null;
        $this->user = null;

        $this->developersToInsert = [];
        $this->franchisesToInsert = [];
        $this->publishersToInsert = [];

        return $this;
    }

    public function setGiantBombGame($id)
    {
        $this->giantBombGame = $this->giantBombHelper->getGame($id, $this->giantBombFields);

        return $this;
    }

    public function setIgdbGame($id)
    {
        $this->igdbGame = $this->igdbHelper->getGameById($id, $this->igdbFields);

        return $this;
    }

    public function setSteamGame($id)
    {
        $this->steamGame = $this->steamHelper->setLanguage(self::STEAM_LANGUAGE)->getGame($id, $this->steamFields);

        return $this;
    }

    public function guessGiantBombGame()
    {
        if(!$this->igdbGame and !$this->steamGame) {
            throw new noApiGameSetException(self::NO_API_GAME_SET_MESSAGE . PHP_EOL);
        }

        if($id = $this->guess($this->giantBombHelper, $this->igdbGame->name ?? $this->steamGame->name)) {
            $this->setGiantBombGame($id);
        }

        return $this;
    }

    public function guessIgdbGame()
    {
        if(!$this->giantBombGame and !$this->steamGame) {
            throw new noApiGameSetException(self::NO_API_GAME_SET_MESSAGE . PHP_EOL);
        }

        if($id = $this->guess($this->igdbHelper, $this->giantBombGame->name ?? $this->steamGame->name)) {
            $this->setIgdbGame($id);
        }

        return $this;
    }

    public function guessSteamGame()
    {
        if(!$this->giantBombGame and !$this->igdbGame) {
            throw new noApiGameSetException(self::NO_API_GAME_SET_MESSAGE . PHP_EOL);
        }

        if($id = $this->guess($this->steamHelper, $this->giantBombGame->name ?? $this->igdbGame->name)) {
            $this->setSteamGame($id);
        }

        return $this;
    }

    public function setUserWhoContributed(User $user)
    {
        $this->user = $user;

        return $this;
    }

   	public function create($publishable = true)
   	{
        $this->throwExceptionIfNoApiGameWasSet();
        $this->throwExceptionIfGameAlreadyExists();

        $this->game = $this->gameFactory->publishable($publishable)->create(new GameDto([
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'release' => $this->getRelease() ?? $this->getExpectedRelease(),
            'classificationId' => $this->getClassification(),
            'cover' => $this->getCover(),
            'background' => $this->getBackground(),
            'campaign' => $this->hasCampaign(),
            'characteristics' => $this->getCharacteristics(),
            'developers' => $this->getDevelopers(),
            'franchises' => $this->getFranchises(),
            'genres' => $this->getGenres(),
            'modes' => $this->getModes(),
            'platforms' => $this->getPlatforms(),
            'publishers' => $this->getPublishers(),
            'themes' => $this->getThemes()
        ]), $this->user);
    	
    	return $this;
    }

    protected function throwExceptionIfNoApiGameWasSet()
    {
        if(!$this->steamGame and !$this->giantBombGame and !$this->igdbGame) {
            throw new NoApiGameSetException(self::NO_API_GAME_SET_MESSAGE . PHP_EOL);
        }
    }

    protected function throwExceptionIfGameAlreadyExists()
    {
        if($this->gameNameDecider->exists($name = $this->getName(), $this->getRelease())) {
            throw new GameAlreadyExistsException($name . ' já existe no catálogo!' . PHP_EOL);
        }
    }

    protected function getName()
    {
        if(isset($this->giantBombGame)) {
            return $this->giantBombGame->name;
        } elseif(isset($this->igdbGame)) {
            return $this->igdbGame->name;
        } elseif(isset($this->steamGame)) {
            return $this->steamGame->name;
        }

        return null;
    }

    protected function getAliases()
    {
        if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'aliases') and $this->giantBombGame->aliases) {
            return array_filter(explode("\n", $this->giantBombGame->aliases));
        }
        
        return [];
    }

    protected function getDescription()
    {
        if(isset($this->steamGame) and property_exists($this->steamGame, 'description') and $this->steamGame->description) {
            return $this->translate($this->steamGame->description);
        } elseif(isset($this->igdbGame) and property_exists($this->igdbGame, 'summary') and $this->igdbGame->summary) {
            return $this->translate($this->igdbGame->summary);
        } elseif(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'deck') and $this->isRelevantDescription($this->giantBombGame->deck)) {
            return $this->translate($this->giantBombGame->deck);
        }

        return null;
    }

    protected function getRelease()
    {
        if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'original_release_date') and $this->giantBombGame->original_release_date) {
            return $this->giantBombGame->original_release_date;
        } elseif(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'releases') and isset($this->giantBombGame->releases[0])) {
            return $this->giantBombHelper->getGameReleaseDate($this->giantBombGame->releases[0]->id);
        } elseif(isset($this->steamGame) and property_exists($this->steamGame, 'release_date') and $this->steamGame->release_date) {
            return $this->steamGame->release_date->format('Y-m-d');
        }
            
        return null;
    }
    
    protected function getExpectedRelease()
    {
        if (isset($this->giantBombGame) &&
            isset($this->giantBombGame->expected_release_day) && 
            isset($this->giantBombGame->expected_release_month) && 
            isset($this->giantBombGame->expected_release_year)
        ) {
            return implode('-', [
                $this->giantBombGame->expected_release_year,
                $this->giantBombGame->expected_release_month,
                $this->giantBombGame->expected_release_day
            ]);
        }
        
        return null;
    }

    protected function getClassification()
    {
        $slug = null;

        if(isset($this->steamGame) and property_exists($this->steamGame, 'classification') and $this->steamGame->classification) {
            $slug = $this->steamGame->classification;
        }

        return $slug ? Classification::whereSlug($slug)->first()->id : null;
    }

    protected function getCover()
    {
        if(isset($this->igdbGame) and property_exists($this->igdbGame, 'cover') and $this->igdbGame->cover) {
            return $this->igdbHelper->replaceToLargerCover($this->igdbGame->cover->url);
        }

        if(isset($this->steamGame) and property_exists($this->steamGame, 'cover') and $this->steamGame->cover) {
            return $this->steamGame->cover;
        }

        if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'image') and $this->giantBombGame->image) {
            return $this->giantBombGame->image->original_url;
        }

        return false;
    }

    protected function getBackground()
    {
        if($this->getScreenshots() and !$this->isClassicGame()) {
            return $this->getScreenshots()[0];
        }
           
        return null;
    }

    protected function hasCampaign()
    {
        return (isset($this->giantBombGame) and property_exists($this->giantBombGame, 'genres') and !$this->hasGenreWithoutCampaign($this->giantBombGame->genres));
    }

    protected function getCharacteristics()
    {
        $slugs = [];

    	if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'genres') and $this->giantBombGame->genres) {
			$slugs = $this->giantBombHelper->matchCharacteristics($this->giantBombGame->genres);
		}
		
		return $slugs ? Characteristic::whereIn('slug', $slugs)->pluck('id') : null;
    }

    protected function getDevelopers()
    {
    	$names = [];

        if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'developers') and $this->giantBombGame->developers) {
            $names = array_merge($names, array_column($this->giantBombGame->developers, 'name'));
        } elseif(isset($this->steamGame) and property_exists($this->steamGame, 'developers') and $this->steamGame->developers) {
            $names = $this->steamGame->developers;
        }

        $names = $this->removeLegalAbbreviations($names);

        $developers = Developer::whereIn('name', $names)->get();

        $this->developersToInsert = $this->filterNamesToInsert($names, $developers);

        return $developers->count() ? $developers->pluck('id')->toArray() : null;
    }

    protected function getFranchises()
    {
        $names = [];

        if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'franchises') and $this->giantBombGame->franchises) {
            $names = array_merge($names, array_column($this->giantBombGame->franchises, 'name'));
        }

        $franchises = Franchise::whereIn('name', $names)->get();

        $this->franchisesToInsert = $this->filterNamesToInsert($names, $franchises);

        return $franchises->count() ? $franchises->pluck('id')->toArray() : null;
    }

    protected function getGenres()
    {
        $slugs = [];

    	if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'genres') and $this->giantBombGame->genres) {
			$slugs = $this->giantBombHelper->matchGenres($this->giantBombGame->genres);
		}
		
		return $slugs ? Genre::whereIn('slug', $slugs)->pluck('id') : null;
    }

    protected function getModes()
    {
        $slugs = [];
        
        if(isset($this->steamGame) and property_exists($this->steamGame, 'modes') and $this->steamGame->modes) {
			$slugs = $this->steamGame->modes;
		} else {
            $modes = [];
            if(isset($this->igdbGame) and property_exists($this->igdbGame, 'game_modes') and $this->igdbGame->game_modes) {
                $modes = array_column($this->igdbGame->game_modes, 'name');
            }

            $multiplayerModes = [];
            if(isset($this->igdbGame) and property_exists($this->igdbGame, 'multiplayer_modes') and $this->igdbGame->multiplayer_modes) {
                $multiplayerModes = $this->igdbGame->multiplayer_modes;
            }

            $slugs = $this->igdbHelper->matchModes($modes, $multiplayerModes);
        }

    	return $slugs ? Mode::whereIn('slug', $slugs)->pluck('id') : null;
    }

    protected function getPlatforms()
    {
        $slugs = [];

    	if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'platforms') and $this->giantBombGame->platforms) {
			$slugs = $this->giantBombHelper->matchPlatforms($this->giantBombGame->platforms);
		}

        if(isset($this->steamGame) and property_exists($this->steamGame, 'platforms') and $this->steamGame->platforms) {
			$slugs = array_merge($slugs, $this->steamGame->platforms);
		}
		
		return $slugs ? Platform::whereIn('slug', $slugs)->pluck('id') : null;
    }

    protected function getPublishers()
    {
    	$names = [];

        if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'publishers') and $this->giantBombGame->publishers) {
            $names = array_merge($names, array_column($this->giantBombGame->publishers, 'name'));
        } elseif(isset($this->steamGame) and property_exists($this->steamGame, 'publishers') and $this->steamGame->publishers) {
            $names = $this->steamGame->publishers;
        }

        $names = $this->removeLegalAbbreviations($names);

        $publishers = Publisher::whereIn('name', $names)->get();

        $this->publishersToInsert = $this->filterNamesToInsert($names, $publishers);

        return $publishers->count() ? $publishers->pluck('id')->toArray() : null;
    }

    protected function getScreenshots()
    {
        $screenshots = [];
    
        if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'images') and $this->giantBombGame->images) {
            $screenshots = array_filter($this->giantBombGame->images, function($screenshot) {
                return stristr($screenshot->tags, 'Screenshot');
            });
            $screenshots = array_column($screenshots, 'original');
        }
		
    	if(!$screenshots) {
        	if(isset($this->igdbGame) and property_exists($this->igdbGame, 'screenshots') and $this->igdbGame->screenshots) {
        	    $screenshots = array_map(function($screenshot) {
                    return $this->igdbHelper->replaceToLargerCover($screenshot->url, 't_original');
                }, $this->igdbGame->screenshots);
        	}
        }

        if(!$screenshots) {
        	if(isset($this->steamGame) and property_exists($this->steamGame, 'screenshots') and $this->steamGame->screenshots) {
        	    $screenshots = $this->steamGame->screenshots;
        	}
        }
    	
    	return array_slice($screenshots, 0, self::TOTAL_SCREENSHOTS);
    }

    protected function getThemes()
    {
        $slugs = [];

    	if(isset($this->giantBombGame) and property_exists($this->giantBombGame, 'themes') and $this->giantBombGame->themes) {
			$slugs = $this->giantBombHelper->matchThemes($this->giantBombGame->themes);
		}
		
		return $slugs ? Theme::whereIn('slug', $slugs)->pluck('id') : null;
    }

    private function filterNamesToInsert($names, $entities)
    {
        return array_filter(array_diff($names, $entities->pluck('name')->toArray()));
    }

    private function guess($helper, $term)
    {
        try {
            $term = Support::removeNonAlphanumeric($term);

            $options = $helper->provideGamesToChoose(
                $term,
                self::TOTAL_GAMES_TO_SEARCH_WHEN_GUESSING
            );

            $idNamePair = array_combine(
                array_column($options, 'id'),
                array_map(function($name) {
                    return Support::removeNonAlphanumeric($name);
                }, array_column($options, 'name'))
            );

            return array_search($term, $idNamePair);
        } catch(ApiNoResponseException $exception) {}
    }

    private function isClassicGame()
    {
        return ($this->getRelease() and $this->getRelease() < config('site.classic_game_date'));
    }

    private function isRelevantDescription($description)
    {
        return strlen($description) > self::MINIMUM_CHARACTERS_RELEVANT_DESCRIPTION;
    }

    private function hasGenreWithoutCampaign($genres)
    {
        return count(array_intersect(self::GENRES_WITHOUT_CAMPAIGN, array_column($genres, 'name'))) > 0;
    }

    private function removeLegalAbbreviations($names)
    {
        return array_map(function($name) {
            return strlen($name) >= self::MINIMUM_CHARACTERS_TO_REMOVE_LEGAL_ABBREVIATIONS ? trim(str_ireplace(self::LEGAL_ABBREVIATIONS, '', $name)) : $name;
        }, $names);
    }

    private function translate($text)
    {
        return $this->translaterHelper
                    ->setText($text)
                    ->ignore($this->getName())
                    ->translateTo(self::LANGUAGE_TO_TRANSLATE);
    }

    use SetAdditionalData;
}