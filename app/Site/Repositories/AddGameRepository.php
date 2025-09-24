<?php
namespace App\Site\Repositories;

use App\Site\Models\{Characteristic, Classification, Developer, Franchise, Genre, Mode, Platform, Publisher, Theme};

class AddGameRepository
{
    protected $characteristic;
    protected $classification;
    protected $developer;
    protected $franchise;
    protected $genre;
    protected $mode;
    protected $platform;
    protected $publisher;
    protected $theme;

    public function __construct(
        Characteristic $characteristic,
        Classification $classification,
        Developer $developer,
        Franchise $franchise,
        Genre $genre,
        Mode $mode,
        Platform $platform,
        Publisher $publisher,
        Theme $theme
    ) {
        $this->characteristic = $characteristic;
        $this->classification = $classification;
        $this->developer = $developer;
        $this->franchise = $franchise;
        $this->genre = $genre;
        $this->mode = $mode;
        $this->platform = $platform;
        $this->publisher = $publisher;
        $this->theme = $theme;
    }

    public function getCharacteristics($localeColumnSuffix)
    {
        return $this->characteristic->select(['id', 'name' . $localeColumnSuffix])->orderBy('name' . $localeColumnSuffix)->get();
    }

    public function getClassifications()
    {
        return $this->classification->select(['id', 'name'])->orderBy('name')->get();
    }

    public function getDevelopers()
    {
        return $this->developer->select(['id', 'name'])->orderBy('name')->get();
    }

    public function getFranchises()
    {
        return $this->franchise->select(['id', 'name'])->orderBy('name')->get();
    }

    public function getGenres($localeColumnSuffix)
    {
        return $this->genre->select(['id', 'name' . $localeColumnSuffix])->orderBy('name' . $localeColumnSuffix)->get();
    }
    
    public function getModes($localeColumnSuffix)
    {
        return $this->mode->select(['id', 'slug', 'name' . $localeColumnSuffix])->orderBy('name' . $localeColumnSuffix, 'desc')->get();
    }
    
    public function getPlatforms()
    {
        return $this->platform->select(['id', 'name'])->inRelevantOrder()->get();
    }
    
    public function getPublishers()
    {
        return $this->publisher->select(['id', 'name'])->orderBy('name')->get();
    }

    public function getThemes($localeColumnSuffix)
    {
        return $this->theme->select(['id', 'name' . $localeColumnSuffix])->orderBy('name' . $localeColumnSuffix)->get();
    }
}