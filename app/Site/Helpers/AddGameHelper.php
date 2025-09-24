<?php
namespace App\Site\Helpers;

use App\Site\Models\{Developer, Game, Publisher};
use App\Site\Repositories\AddGameRepository;
use App\Common\Helpers\{Support, TagsFiltering};
use App\Common\Rules\UniqueRule;
use App\Console\Exceptions\ApiNoResponseException;
use App\Console\Helpers\GiantBombHelper;
use App\Console\Services\SteamCatalogService;

class AddGameHelper
{
    protected $addGameRepository;
    protected $giantBombHelper;
    protected $localeColumnSuffix;
    protected $tagsFiltering;

    public function __construct(AddGameRepository $addGameRepository, GiantBombHelper $giantBombHelper, TagsFiltering $tagsFiltering)
    {
        $this->addGameRepository = $addGameRepository;
        $this->giantBombHelper = $giantBombHelper;
        $this->localeColumnSuffix = config('site.locale_column_suffix');
        $this->tagsFiltering = $tagsFiltering;
    }

    public function filterTags(Game $game)
    {
        $this->tagsFiltering->setGame($game)->handleAllAndSync();
    }

    public function saveNewDeveloperAndPublisher(Game $game, string $newDeveloperName, ?bool $createPublisherWithSameName)
    {
        $uniqueRule = new UniqueRule('developers', 'name');

        if ($uniqueRule->passes('', $newDeveloperName)) {
            $newDeveloper = new Developer();
            $newDeveloper->status = 1;
            $newDeveloper->slug = str_slug($newDeveloperName);
            $newDeveloper->name = $newDeveloperName;
            $newDeveloper->save();
            $game->developers()->attach($newDeveloper);

            if ($createPublisherWithSameName) {
                $newPublisher = new Publisher();
                $newPublisher->status = 1;
                $newPublisher->slug = str_slug($newDeveloperName);
                $newPublisher->name = $newDeveloperName;
                $newPublisher->save();
                $game->publishers()->attach($newPublisher);
            }
        }
    }

    public function getCharacteristics()
    {
        return $this->addGameRepository->getCharacteristics($this->localeColumnSuffix);
    }

    public function getDevelopers()
    {
        return $this->addGameRepository->getDevelopers();
    }

    public function getFranchises()
    {
        return $this->addGameRepository->getFranchises();
    }

    public function getGenres()
    {
        return $this->addGameRepository->getGenres($this->localeColumnSuffix);
    }
    
    public function getModes()
    {
        return $this->addGameRepository->getModes($this->localeColumnSuffix);
    }
    
    public function getPlatforms()
    {
        return $this->addGameRepository->getPlatforms();
    }
    
    public function getPublishers()
    {
        return $this->addGameRepository->getPublishers();
    }

    public function getThemes()
    {
        return $this->addGameRepository->getThemes($this->localeColumnSuffix);
    }

    public function getGamesFromGiantBomb($name, $total)
    {
        try {
			return $this->giantBombHelper->provideGamesToChoose($name, $total);
		} catch(ApiNoResponseException $exception) {
			return [];
		}
    }

    public function getGamesFromSteam($name, $total)
    {
        return resolve(SteamCatalogService::class)->provideGamesToChoose($name, $total);
    }

    public function isGameInTheResults($apiGames, $name)
    {
        return $apiGames and Support::searchArrayOfObjects($apiGames, 'name', $name);
    }
}