<?php
namespace App\Common\DTOs;

use App\Common\Helpers\Support;

use JsonSerializable;

class GameDto implements JsonSerializable
{
    private $name;
    private $alias;
    private $description;
    private $release;
    private $isEarlyAccess;
    private $trailer;
    private $classificationId;
    private $cover;
    private $background;
    private $campaign;
    private $characteristics;
    private $criterias;
    private $developers;
    private $franchises;
    private $genres;
    private $modes;
    private $platforms;
    private $publishers;
    private $themes;

    public function __construct(array|object $data)
    {
        $data = (object) $data;

        $this->setName($data->name ?? null);
        $this->setAlias($data->alias ?? null);
        $this->setDescription($data->description ?? null);
        $this->setRelease($data->release ?? null);
        $this->setIsEarlyAccess($data->isEarlyAccess ?? $data->is_early_access ?? null);
        $this->setTrailer($data->trailer ?? null);
        $this->setClassificationId($data->classificationId ?? $data->classification_id ?? null);
        $this->setCover($data->cover ?? null);
        $this->setBackground($data->background ?? null);
        $this->setCampaign($data->campaign ?? null);
        $this->setCharacteristics($data->characteristics ?? null);
        $this->setCriterias($data->criterias ?? null);
        $this->setDevelopers($data->developers ?? null);
        $this->setFranchises($data->franchises ?? null);
        $this->setGenres($data->genres ?? null);
        $this->setModes($data->modes ?? null);
        $this->setPlatforms($data->platforms ?? null);
        $this->setPublishers($data->publishers ?? null);
        $this->setThemes($data->themes ?? null);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getRelease()
    {
        return $this->release;
    }

    public function getIsEarlyAccess()
    {
        return $this->isEarlyAccess;
    }

    public function getTrailer()
    {
        return $this->trailer;
    }

    public function getClassificationId()
    {
        return $this->classificationId;
    }

    public function getCover()
    {
        return $this->cover;
    }

    public function getBackground()
    {
        return $this->background;
    }

    public function getCampaign()
    {
        return $this->campaign;
    }

    public function getCharacteristics()
    {
        return $this->characteristics;
    }

    public function getCriterias()
    {
        return $this->criterias;
    }

    public function getDevelopers()
    {
        return $this->developers;
    }

    public function getFranchises()
    {
        return $this->franchises;
    }

    public function getGenres()
    {
        return $this->genres;
    }

    public function getModes()
    {
        return $this->modes;
    }

    public function getPlatforms()
    {
        return $this->platforms;
    }

    public function getPublishers()
    {
        return $this->publishers;
    }

    public function getThemes()
    {
        return $this->themes;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public function setDescription($description)
    {
        $this->description = nl2br(strip_tags($description));
    }

    public function setRelease($release)
    {
        $this->release = $release ? Support::parseDate($release) : null;
    }

    public function setIsEarlyAccess($isEarlyAccess)
    {
        $this->isEarlyAccess = $isEarlyAccess;
    }

    public function setTrailer($trailer)
    {
        $this->trailer = Support::extractIdFromYoutubeURL($trailer);
    }

    public function setClassificationId($classificationId)
    {
        $this->classificationId = $classificationId;
    }

    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    public function setBackground($background)
    {
        $this->background = $background;
    }

    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    }

    public function setCharacteristics($characteristics)
    {
        $this->characteristics = $characteristics;
    }

    public function setCriterias($criterias)
    {
        $this->criterias = $criterias;
    }

    public function setDevelopers($developers)
    {
        $this->developers = $developers;
    }

    public function setFranchises($franchises)
    {
        $this->franchises = $franchises;
    }

    public function setGenres($genres)
    {
        $this->genres = $genres;
    }

    public function setModes($modes)
    {
        $this->modes = $modes;
    }

    public function setPlatforms($platforms)
    {
        $this->platforms = $platforms;
    }

    public function setPublishers($publishers)
    {
        $this->publishers = $publishers;
    }

    public function setThemes($themes)
    {
        $this->themes = $themes;
    }

    public function all()
    {
        return (object) [
            'name' => $this->getName(),
            'alias' => $this->getAlias(),
            'description' => $this->getDescription(),
            'release' => $this->getRelease(),
            'isEarlyAccess' => $this->getIsEarlyAccess(),
            'trailer' => $this->getTrailer(),
            'classificationId' => $this->getClassificationId(),
            'cover' => $this->getCover(),
            'background' => $this->getBackground(),
            'campaign' => $this->getCampaign(),
            'characteristics' => $this->getCharacteristics(),
            'criterias' => $this->getCriterias(),
            'developers' => $this->getDevelopers(),
            'franchises' => $this->getFranchises(),
            'genres' => $this->getGenres(),
            'modes' => $this->getModes(),
            'platforms' => $this->getPlatforms(),
            'publishers' => $this->getPublishers(),
            'themes' => $this->getThemes(),
        ];
    }

    public function getRelationships()
    {
        return (object) [
            'characteristics' => $this->getCharacteristics(),
            'criterias' => $this->getCriterias(),
            'developers' => $this->getDevelopers(),
            'franchises' => $this->getFranchises(),
            'genres' => $this->getGenres(),
            'modes' => $this->getModes(),
            'platforms' => $this->getPlatforms(),
            'publishers' => $this->getPublishers(),
            'themes' => $this->getThemes(),
        ];
    }

    public function asArray()
    {
        return (array) $this->all();
    }

    public function jsonSerialize()
    {
        return (array) $this->all();
    }
}
