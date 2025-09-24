<?php
namespace App\Console\Actions\Game;

use App\Site\Models\Game;
use App\Console\Helpers\IgdbHelper;

class FetchBackground
{
    protected $helper;

    public function __construct(IgdbHelper $helper)
    {
        $this->helper = $helper;
    }

    public function fetch(Game $game)
    {
        $screenshots = $this->helper->getGameScreenshots($game->slug);

        if(count($screenshots)) {
            $game->uploadBackground($screenshots[0]);

            return true;
        }

        return false;
    }
}