<?php
namespace App\Console\Actions\Game;

use App\Console\Exceptions\{ApiNoResponseException, GameHasNoPlatformException, GameHasNoPlatformOnMetacriticException, NoApiGameFoundException, ReleaseDateNotFoundException};
use App\Site\Models\Game;

class TouchUp
{
    protected const LANGUAGE = 'pt-br';

    protected $fetchBackground;
    protected $fetchCover;
    protected $fetchCriticScore;
    protected $fetchDescription;
    protected $fetchScreenshots;
    protected $fetchTags;
    protected $fetchTrailer;
    protected $fetchReleaseDate;

	public function __construct(
        FetchBackground $fetchBackground,
        FetchCover $fetchCover,
        FetchCriticScore $fetchCriticScore,
        FetchDescription $fetchDescription,
        FetchScreenshots $fetchScreenshots,
        FetchTags $fetchTags,
        FetchTrailer $fetchTrailer,
        FetchReleaseDate $fetchReleaseDate
    ) {
        $this->fetchBackground = $fetchBackground;
        $this->fetchCover = $fetchCover;
        $this->fetchCriticScore = $fetchCriticScore;
        $this->fetchDescription = $fetchDescription;
        $this->fetchScreenshots = $fetchScreenshots;
        $this->fetchTags = $fetchTags;
        $this->fetchTrailer = $fetchTrailer;
        $this->fetchReleaseDate = $fetchReleaseDate;
    }
	
	public function handle(Game $game)
    {
        try {
            echo 'Procurando cover' . PHP_EOL;
            if($this->fetchCover->fetch($game)) {
                echo 'Cover adicionado com sucesso.' . PHP_EOL;
            } else {
                echo 'Cover não encontrado.' . PHP_EOL;
            }
        } catch(ApiNoResponseException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        try {
            echo 'Procurando background' . PHP_EOL;
            if($this->fetchBackground->fetch($game)) {
                echo 'Background adicionado com sucesso.' . PHP_EOL;
            } else {
                echo 'Background não encontrado.' . PHP_EOL;
            }
        } catch(ApiNoResponseException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
        
        try {
            echo 'Procurando nota da crítica' . PHP_EOL;
            if($this->fetchCriticScore->setGame($game)->fetch()) {
                echo 'Nota da crítica adicionada com sucesso.' . PHP_EOL;
            } else {
                echo 'Nota da crítica não encontrada.' . PHP_EOL;
            }
        } catch(GameHasNoPlatformException|GameHasNoPlatformOnMetacriticException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        try {
            echo 'Procurando descrição' . PHP_EOL;
            if($this->fetchDescription->setGame($game)->setLanguage(self::LANGUAGE)->fetch()) {
                echo 'Descrição adicionada com sucesso.' . PHP_EOL;
            } else {
                echo 'Descrição não encontrada.' . PHP_EOL;
            }
        } catch(NoApiGameFoundException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        try {
            echo 'Procurando screenshots' . PHP_EOL;
            if($this->fetchScreenshots->fetch($game, $renew = true)) {
                echo 'Screenshots adicionados com sucesso.' . PHP_EOL;
            } else {
                echo 'Screenshots não encontrados.' . PHP_EOL;
            }
        } catch(ApiNoResponseException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        try {
            echo 'Procurando tags' . PHP_EOL;
            $this->fetchTags->setGame($game)->fetchThenSyncAll()->filter();
            echo 'Tags adicionadas com sucesso.' . PHP_EOL;
        } catch(NoApiGameFoundException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        try {
            if($game->isUndated()) {
                echo 'Procurando data de lançamento' . PHP_EOL;
                $this->fetchReleaseDate->setGame($game)->crawl();
                $this->fetchReleaseDate->save();
            }
        } catch(NoApiGameFoundException|ReleaseDateNotFoundException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        try {
            echo 'Procurando trailer' . PHP_EOL;
            if($this->fetchTrailer->setGame($game)->fetch()) {
                echo 'Trailer adicionado com sucesso.' . PHP_EOL;
            } else {
                echo 'Trailer não encontrado.' . PHP_EOL;
            }
        } catch(ApiNoResponseException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }
}