<?php
namespace App\Console\Actions\Game;

use App\Console\Exceptions\NoGameSetException;
use App\Console\Helpers\{SteamHelper, TranslaterHelper};
use App\Site\Models\Game;

class FetchDescription
{
    private $game;
    private $language;
    private $steamHelper;
    private $translaterHelper;

	public function __construct(
        SteamHelper $steamHelper,
        TranslaterHelper $translaterHelper
    ) {
		$this->steamHelper = $steamHelper;
        $this->translaterHelper = $translaterHelper;
	}

    public function setGame(Game $game)
    {
        $this->steamHelper->setGame($game);
        $this->game = $game;

        return $this;
    }

    public function setLanguage(string $language)
    {
        $this->language = $language;
        $this->steamHelper->setLanguage($language);

        return $this;
    }
	
    public function fetch()
    {
        if(!$this->game) {
            throw new NoGameSetException('Jogo não informado' . PHP_EOL);
        }

        if($description = $this->steamHelper->getDescription()) {
            $this->game->timestamps = false;
            $this->game->description = $this->translate($description);
            $this->game->save();
            return true;
        }
        
        return false;
    }

    private function translate($text)
    {
        return $this->translaterHelper
                ->setText($text)
                ->ignore($this->game->name)
                ->translateTo($this->language);
    }
}