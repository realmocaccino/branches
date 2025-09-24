<?php
namespace App\Console\Actions\Game;

use App\Console\Helpers\SteamHelper;
use App\Site\Models\{Game, Mode};

class FetchModes
{
	public $game;
    public $helper;

    public function __construct(SteamHelper $helper)
    {
        $this->helper = $helper;
    }

    public function setGame(Game $game)
    {
        $this->helper->setGame($game);
        $this->game = $game;

        return $this;
    }
	
    public function fetch()
    {
        if($slugs = $this->helper->getModes()) {
            $this->sync($slugs);
        }

        return $this;
    }

    private function sync($slugs)
    {
        $this->game->modes()->sync(Mode::whereIn('slug', $slugs)->pluck('id'));
    }
}