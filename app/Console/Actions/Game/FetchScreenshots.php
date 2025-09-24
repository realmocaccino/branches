<?php
namespace App\Console\Actions\Game;

use App\Site\Models\{Game, Screenshot};
use App\Console\Helpers\IgdbHelper;

class FetchScreenshots
{
    protected $helper;

    public function __construct(IgdbHelper $helper)
    {
        $this->helper = $helper;
    }

    public function fetch(Game $game, bool $renew = false)
    {
        if($renew) $this->clearScreenshots($game);

        $screenshots = $this->helper->getGameScreenshots($game->slug);

        if(count($screenshots)) {
            foreach ($screenshots as $filename) {
                $screenshot = new Screenshot();
                $screenshot->save();
                $screenshot->uploadAndHandleFilename($filename);
                $game->screenshots()->save($screenshot);
            }

            return true;
        }

        return false;
    }

    private function clearScreenshots(Game $game)
    {
        (new ClearScreenshots($game->slug))->clear();
    }
}