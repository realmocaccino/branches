<?php
namespace App\Console\Actions\Game;

use App\Site\Models\Game;

class AttachBackground
{
	public $game;

    public function __construct($gameSlug)
    {
    	$this->game = Game::findBySlugOrFail($gameSlug);
    }

    public function attach($url)
    {
    	$this->game->timestamps = false;
    	$this->game->uploadFile('background', $url);
    }
}