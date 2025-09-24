<?php
namespace App\Common\Deciders;

use App\Common\Exceptions\GameAlreadyExistsException;
use App\Common\Helpers\Support;
use App\Site\Repositories\GameRepository;

class GameNameDecider
{
    private const COMPOUND_NAME_FORMAT = '%s (%s)';
    private const WITHOUT_RELEASE_DATE_TERM = 'TBA';

    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function createNameUnlessAlreadyExists(string $name, string $release = null, int $idToExclude = null)
    {
        if ($this->exists($name, $release, $idToExclude)) {
            return null;
        }

        if ($this->existsByName($name, $idToExclude)) {
            return $this->generateCompoundName($name, $release);
        }

        return $name;
    }

    public function createNameOrFailIfAlreadyExists(string $name, string $release = null, int $idToExclude = null)
    {
        if ($name = $this->createNameUnlessAlreadyExists($name, $release, $idToExclude)) {
            return $name;
        }

        throw new GameAlreadyExistsException();
    }

    public function exists(string $name, string $release = null, int $idToExclude = null)
    {
        $releaseYear = $release ? Support::getYearFromDate($release) : null;

        if ($existingGame = $this->gameRepository->doesItAlreadyExist($name, $releaseYear, $idToExclude)) {
            return $existingGame;
        }
        
        return $this->gameRepository->doesItAlreadyExistByName($this->generateCompoundName($name, $release), $idToExclude);
    }

    private function existsByName(string $name, int $idToExclude = null)
    {        
        return $this->gameRepository->doesItAlreadyExistByName($name, $idToExclude);
    }

    private function generateCompoundName(string $name, string $release = null)
    {
        $releaseYear = $release ? Support::getYearFromDate($release) : self::WITHOUT_RELEASE_DATE_TERM;

        return sprintf(self::COMPOUND_NAME_FORMAT, $name, $releaseYear);
    }
}