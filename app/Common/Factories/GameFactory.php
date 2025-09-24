<?php
namespace App\Common\Factories;

use App\Common\Deciders\GameNameDecider;
use App\Common\DTOs\GameDto;
use App\Common\Events\GameAddedEvent;
use App\Site\Models\{Criteria, Game, User};

class GameFactory
{
    private $gameNameDecider;

    protected $game;
    protected $status = true;

    public function __construct(GameNameDecider $gameNameDecider)
    {
        $this->gameNameDecider = $gameNameDecider;
    }

    public function publishable($status = true)
    {
        $this->status = $status;

        return $this;
    }

    public function create(GameDto $data, User $user = null)
    {
        $this->game = new Game;
        $this->game->status = $this->status;
        $this->game->name = $this->processName($data->getName(), $data->getRelease());
        $this->game->alias = $data->getAlias();
        $this->game->description = $data->getDescription();
        $this->game->release = $data->getRelease();
        $this->game->is_early_access = $data->getIsEarlyAccess();
        $this->game->trailer = $data->getTrailer();
        $this->game->classification_id = $data->getClassificationId();
        $this->game->slug = str_slug($this->game->name);
        $this->game->save();

        $this->syncRelationships($data);
        $this->handleAssets($data);

        $this->fireEvent($user);

        return $this->game;
    }

    public function update(Game $game, GameDto $data)
    {
        $this->game = $game;
        $this->game->status = $this->status;
        if($name = $data->getName()) $this->game->name = $this->processName($name, $data->getRelease(), $this->game->id);
        if($alias = $data->getAlias()) $this->game->alias = $alias;
        if($description = $data->getDescription()) $this->game->description = $description;
        if($release = $data->getRelease()) $this->game->release = $release;
        if($isEarlyAccess = $data->getIsEarlyAccess()) $this->game->is_early_access = $isEarlyAccess;
        if($trailer = $data->getTrailer()) $this->game->trailer = $trailer;
        if($classificationId = $data->getClassificationId()) $this->game->classification_id = $classificationId;
        $this->game->slug = str_slug($this->game->name);
        $this->game->save();

        $this->syncRelationships($data);
        $this->handleAssets($data);
        
        return $this->game;
    }

    protected function fireEvent(?User $user)
    {
        event(new GameAddedEvent($this->game, $user));
    }

    protected function handleAssets(GameDto $data)
    {
        if($cover = $data->getCover()) $this->game->uploadCover($cover);
        if($background = $data->getBackground()) $this->game->uploadBackground($background);
    }

    protected function processName($name, $release, $id = null)
    {
        return $this->gameNameDecider->createNameOrFailIfAlreadyExists($name, $release, $id);
    }

    protected function syncRelationships(GameDto $data)
    {
        $this->game->criterias()->sync($this->getCriterias($data->getCampaign()));
        
        if($data->getCharacteristics()) {
            $this->game->characteristics()->sync($data->getCharacteristics());
        }
        if($data->getDevelopers()) {
            $this->game->developers()->sync($data->getDevelopers());
        }
        if($data->getFranchises()) {
            $this->game->franchises()->sync($data->getFranchises());
        }
        if($data->getGenres()) {
            $this->game->genres()->sync($data->getGenres());
        }
        if($data->getModes()) {
            $this->game->modes()->sync($data->getModes());
        }
        if($data->getPlatforms()) {
            $this->game->platforms()->sync($data->getPlatforms());
        }
        if($data->getPublishers()) {
            $this->game->publishers()->sync($data->getPublishers());
        }
        if($data->getThemes()) {
            $this->game->themes()->sync($data->getThemes());
        }
    }

    private function getCriterias(bool $hasCampaign)
    {
        return Criteria::select('id')->where('slug', '!=', $hasCampaign ? 'fun' : 'campaign')->get();
    }
}