<?php
namespace App\Site\Helpers;

use App\Common\Deciders\GameNameDecider;
use App\Common\DTOs\GameDto;
use App\Common\Factories\GameFactory;
use App\Common\Helpers\Support;
use App\Site\Helpers\Site;
use App\Site\Mails\NewEditionRequestMail;
use App\Site\Models\{EditionRequest, Game, User};

use Illuminate\Support\Facades\Mail;

class EditGameHelper
{
    private $addGameHelper;
    private $gameFactory;
    private $gameNameDecider;

    private $game;
    private $user;

    public function __construct(AddGameHelper $addGameHelper, GameFactory $gameFactory, GameNameDecider $gameNameDecider)
    {
        $this->addGameHelper = $addGameHelper;
        $this->gameFactory = $gameFactory;
        $this->gameNameDecider = $gameNameDecider;
    }

    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    public function setUser(?User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function canEdit()
    {
        return $this->game
                    ->contributions()
                    ->whereUserId($this->user->id)
                    ->whereType('game_creation')
                    ->where('contributions.created_at', '>=', now()->subDay())
                    ->exists() || Site::isOfficialUser($this->user);
    }

    public function checkIfGameAlreadyExists($name, $release)
    {
        return $this->gameNameDecider->exists($name, $release, $this->game->id);
    }

    public function checkForModification($data)
    {
        return Support::arrayDiffAssocMulti(array_intersect_key($this->game->getAllAttributes(), $data), $data);
    }

    public function createEditionRequest($id, $data)
    {
        return EditionRequest::create([
            'user_id' => $this->user->id,
            'model_name' => 'Game',
            'entity_id' => $id,
            'request' => $data
        ]);
    }

    public function getCharacteristics()
    {
        return $this->addGameHelper->getCharacteristics();
    }

    public function getDevelopers()
    {
        return $this->addGameHelper->getDevelopers();
    }

    public function getFranchises()
    {
        return $this->addGameHelper->getFranchises();
    }

    public function getGenres()
    {
        return $this->addGameHelper->getGenres();
    }
    
    public function getModes()
    {
        return $this->addGameHelper->getModes();
    }
    
    public function getPlatforms()
    {
        return $this->addGameHelper->getPlatforms();
    }
    
    public function getPublishers()
    {
        return $this->addGameHelper->getPublishers();
    }

    public function getThemes()
    {
        return $this->addGameHelper->getThemes();
    }

    public function sendEditionRequestMail($mailTo)
    {
        Mail::to($mailTo)->send(new NewEditionRequestMail('Game', $this->game->name, $this->user));
    }

    public function update($data)
    {
        return $this->gameFactory->update($this->game, new GameDTO($data));
    }
}