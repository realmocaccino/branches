<?php
namespace App\Console\Actions\Game;

use App\Common\Helpers\TagsFiltering;
use App\Console\Helpers\SteamHelper;
use App\Site\Helpers\Site;
use App\Site\Models\{Characteristic, Game, Genre, Theme};

class FetchTags
{
	public $game;
    public $helper;
    public $filtering;

    public function __construct(SteamHelper $helper, TagsFiltering $filtering)
    {
        $this->helper = $helper;
        $this->filtering = $filtering;
    }

    public function setGame(Game $game)
    {
        $this->helper->setGame($game);
        $this->filtering->setGame($game);
        $this->game = $game;

        return $this;
    }

    public function fetchThenSyncAll()
    {
        $tags = $this->helper->getTags();

        $this->syncCharacteristics($tags->characteristics);
        $this->syncGenres($tags->genres);
        $this->syncThemes($tags->themes);
        $this->syncCollections($tags->collections);

        return $this;
    }

    public function filter()
    {
        $this->filtering->handleAllAndSync();

        return $this;
    }

    public function syncCharacteristics(array $slugs)
    {
        $this->game->characteristics()->syncWithoutDetaching(Characteristic::whereIn('slug', $slugs)->pluck('id'));

        return $this;
    }

    public function syncGenres(array $slugs)
    {
        $this->game->genres()->syncWithoutDetaching(Genre::whereIn('slug', $slugs)->pluck('id'));

        return $this;
    }

    public function syncThemes(array $slugs)
    {
        $this->game->themes()->syncWithoutDetaching(Theme::whereIn('slug', $slugs)->pluck('id'));

        return $this;
    }

    public function syncCollections(array $slugs)
    {
        if($officialUser = Site::getOfficialUser()) {
            foreach($slugs as $slug) {
                $collection = $officialUser->collections()->whereSlug($slug)->firstOrFail();
                $collection->games()->syncWithoutDetaching($this->game->id);
                $collection->touch();
            }
        }

        return $this;
    }
}