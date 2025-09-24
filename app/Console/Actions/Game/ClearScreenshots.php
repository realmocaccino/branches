<?php
namespace App\Console\Actions\Game;

use App\Site\Models\Game;

class ClearScreenshots
{
	protected $game;

    public function __construct($gameSlug)
    {
    	$this->game = Game::findBySlugOrFail($gameSlug);
    }

    public function clear()
    {
    	foreach($this->game->screenshots as $screenshot) {
    		$screenshot->deleteFile('filename');
    		$screenshot->delete();
    	}
    }
}