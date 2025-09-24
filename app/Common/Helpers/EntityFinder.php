<?php
namespace App\Common\Helpers;

use App\Site\Models\{Characteristic, Criteria, Developer, Franchise, Genre, Mode, Platform, Publisher, Theme};
use App\Common\Dictionaries\FindDictionary;

class EntityFinder
{
    protected const MODELS = [
        'characteristic' => Characteristic::class,
        'criteria' => Criteria::class,
        'developer' => Developer::class,
        'franchise' => Franchise::class,
        'genre' => Genre::class,
        'mode' => Mode::class,
        'platform' => Platform::class,
        'publisher' => Publisher::class,
        'theme' => Theme::class
    ];

    public static function discover(string $word)
    {
        if($entity = self::discoverBySlug($word)) {
            return $entity;
        }

        if($entity = self::discoverByName($word)) {
            return $entity;
        }

        if($entity = self::discoverByDictionary($word)) {
            return $entity;
        }

        return null;
    }

    public static function discoverBySlug(string $slug)
    {
        foreach(self::MODELS as $model) {
            if($entity = $model::whereSlug($slug)->first()) {
                return $entity;
            }
        }

        return null;
    }

    public static function discoverByName(string $name)
    {
        foreach(self::MODELS as $model) {
            $column = Support::getLocalizatedColumn($model, 'name');

            if($entity = $model::where($column, $name)->first()) {
                return $entity;
            }
        }

        return null;
    }

    public static function discoverByDictionary(string $word)
    {
        if(isset(FindDictionary::$words[$word])) {
            return self::discoverBySlug(FindDictionary::$words[$word]);
        }

        return null;
    }

    public static function getModelInstanceByString($name)
	{
		if(isset(self::MODELS[$name])) {
            $className = self::MODELS[$name];
            
            return new $className;
        }

        return null;
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
        return $this->platform->select(['id', 'name'])->orderBy('name')->get();
    }
    
    public function getPublishers()
    {
        return $this->publisher->select(['id', 'name'])->orderBy('name')->get();
    }

    public function getThemes($localeColumnSuffix)
    {
        return $this->theme->select(['id', 'name' . $localeColumnSuffix])->orderBy('name' . $localeColumnSuffix)->get();
    }

    public static function isCharacteristic(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Characteristic;
    }

    public static function isCriteria(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Criteria;
    }

    public static function isDeveloper(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Developer;
    }

    public static function isFranchise(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Franchise;
    }

    public static function isGenre(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Genre;
    }

    public static function isMode(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Mode;
    }

    public static function isPlatform(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Platform;
    }

    public static function isPublisher(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Publisher;
    }

    public static function isTheme(string $slug): bool
    {
        return self::discoverBySlug($slug) instanceof Theme;
    }
}