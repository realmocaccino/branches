<?php
namespace App\Console\Actions\Game\Traits;

use App\Site\Models\{Developer, Franchise, Publisher, Screenshot};
use App\Console\Exceptions\{GameHasNoPlatformException, GameHasNoPlatformOnMetacriticException, NoApiGameFoundException, ReleaseDateNotFoundException};

Trait SetAdditionalData
{
    protected function attachAliasToTheGame($alias)
    {
        $this->game->alias = $this->game->alias ? $this->game->alias . self::ALIAS_SEPARATOR . $alias : $alias;
    	$this->game->save();
    }
    
    protected function createDeveloperAndAttachToTheGame($name)
    {
    	$developer = new Developer;
    	$developer->slug = str_slug($name, '-');
    	$developer->name = trim($name);
    	$developer->status = 1;
    	$developer->save();
    	
    	$this->game->developers()->attach($developer);
    }

    protected function createFranchiseAndAttachToTheGame($name)
    {
    	$franchise = new Franchise;
    	$franchise->slug = str_slug($name, '-');
    	$franchise->name = trim($name);
    	$franchise->status = 1;
    	$franchise->save();
    	
    	$this->game->franchises()->attach($franchise);
    }
    
    protected function createPublisherAndAttachToTheGame($name)
    {
    	$publisher = new Publisher;
    	$publisher->slug = str_slug($name, '-');
    	$publisher->name = trim($name);
    	$publisher->status = 1;
    	$publisher->save();

    	$this->game->publishers()->attach($publisher);
    }

    protected function fetchAndFilterTags()
    {
        $this->fetchTags->setGame($this->game)->fetchThenSyncAll()->filter();
    }

    protected function getDevelopersToInsert()
    {
        return $this->developersToInsert;
    }

    protected function getFranchisesToInsert()
    {
        return $this->franchisesToInsert;
    }

    protected function getPublishersToInsert()
    {
        return $this->publishersToInsert;
    }

    protected function hasAliases()
    {
        return count($this->getAliases());
    }

    protected function hasDevelopersToInsert()
    {
        return count($this->developersToInsert);
    }

    protected function hasFranchisesToInsert()
    {
        return count($this->franchisesToInsert);
    }

    protected function hasPublishersToInsert()
    {
        return count($this->publishersToInsert);
    }

    protected function saveScreenshotsAndAttachToTheGame()
    {
		if($screenshots = $this->getScreenshots()) {
			foreach($screenshots as $filename) {
				$screenshot = new Screenshot();
				$screenshot->save();
				$screenshot->uploadAndHandleFilename($filename);
				
				$this->game->screenshots()->save($screenshot);
			}
		}
    }

    protected function setCriticScore()
    {
        try {
            $this->fetchCriticScore->setGame($this->game)->fetch();
        } catch(GameHasNoPlatformException|GameHasNoPlatformOnMetacriticException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }

    protected function setRelease()
    {
        try {
            $this->fetchReleaseDate->setGame($this->game)->crawl();

            if($this->fetchReleaseDate->getDate()) {
                $this->fetchReleaseDate->save();
            }
        } catch(ReleaseDateNotFoundException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }

    protected function setTrailer()
    {
        $this->fetchTrailer->setGame($this->game)->fetch();
    }

    public function setAdditionalData($console = null)
    {
        $actions = [];

        $actions[] = [
            'method' => 'fetchAndFilterTags',
            'arguments' => [],
            'question' => ''
        ];

        if($this->game->isAvailable()) {
            $actions[] = [
                'method' => 'setCriticScore',
                'arguments' => [],
                'question' => ''
            ];
        }

        if($this->game->isUndated()) {
            $actions[] = [
                'method' => 'setRelease',
                'arguments' => [],
                'question' => ''
            ];
        }

        if(!$this->game->isClassic()) {
            $actions[] = [
                'method' => 'setTrailer',
                'arguments' => [],
                'question' => ''
            ];
        }

        if($this->hasAliases()) {
            foreach($this->getAliases() as $alias) {
                $actions[] = [
                    'method' => 'attachAliasToTheGame',
                    'arguments' => [$alias],
                    'question' => 'Deseja anexar o apelido ' . $alias . ' ao jogo?'
                ];
            }
        }

        if($this->hasDevelopersToInsert()) {
            foreach($this->getDevelopersToInsert() as $name) {
                $actions[] = [
                    'method' => 'createDeveloperAndAttachToTheGame',
                    'arguments' => [$name],
                    'question' => 'Deseja criar a desenvolvedora ' . $name . ' e anexar ao jogo?'
                ];
            }
        }

        if($this->hasPublishersToInsert()) {
            foreach($this->getPublishersToInsert() as $name) {
                $actions[] = [
                    'method' => 'createPublisherAndAttachToTheGame',
                    'arguments' => [$name],
                    'question' => 'Deseja criar a publicadora ' . $name . ' e anexar ao jogo?'
                ];
            }
        }

        if($this->hasFranchisesToInsert()) {
            foreach($this->getFranchisesToInsert() as $name) {
                $actions[] = [
                    'method' => 'createFranchiseAndAttachToTheGame',
                    'arguments' => [$name],
                    'question' => 'Deseja criar a franquia ' . $name . ' e anexar ao jogo?'
                ];
            }
        }

        if($this->getScreenshots()) {
            $actions[] = [
                'method' => 'saveScreenshotsAndAttachToTheGame',
                'arguments' => [],
                'question' => 'Deseja anexar capturas de tela ao jogo?'
            ];
        }

        foreach($actions as $action) {
            try {
                if($console and $action['question']) {
                    if($console->confirm($action['question'])) $this->{$action['method']}(...$action['arguments']);
                } else {
                    $this->{$action['method']}(...$action['arguments']);
                }
            } catch(NoApiGameFoundException $exception) {}
        }

        return $this;
    }
}