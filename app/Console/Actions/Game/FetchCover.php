<?php
namespace App\Console\Actions\Game;

use App\Console\Helpers\IgdbHelper;
use App\Site\Models\Game;

class FetchCover
{
    protected $helper;

	public function __construct(IgdbHelper $helper)
    {
        $this->helper = $helper;
    }
	
	public function fetch(Game $game)
    {
        if($cover = $this->helper->getGameCover($game->slug)) {
            $game->uploadCover($cover);
            $game->save();
            return true;
        }
        return false;
    }
}