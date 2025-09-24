<?php
namespace App\Console\Actions\Game;

use App\Site\Models\Game;

class AttachCover
{
	public $game;

    public function __construct($gameSlug)
    {
    	$this->game = Game::findBySlugOrFail($gameSlug);
    }

    public function attach($url)
    {
    	$this->game->timestamps = false;
    	$this->game->uploadFile('cover', $url);
    }
}