<?php
namespace App\Console\Helpers;

use App\Console\Repositories\AwardsRepository;
use App\Common\Helpers\EntityFinder;

class AwardsHelper
{
    protected $awardsRepository;
    protected $entityFinder;

    const GOTY = 'goty';

    public function __construct(AwardsRepository $awardsRepository, EntityFinder $entityFinder)
    {
        $this->awardsRepository = $awardsRepository;
        $this->entityFinder = $entityFinder;
    }

    public function getGames($year, $slug)
    {
        if($this->isGoty($slug)) {
            return $this->awardsRepository->getGames(
                $this->getDateReleaseStart($year),
                $this->getDateReleaseEnd($year)
            );
        } elseif($this->isCriteria($slug)) {
            return $this->awardsRepository->getGamesByCriteria(
                $this->getDateReleaseStart($year),
                $this->getDateReleaseEnd($year),
                $slug
            );
        } elseif($additionalSql = $this->getAdditionalSql($slug)) {
            return $this->awardsRepository->getGamesByCategory(
                $this->getDateReleaseStart($year),
                $this->getDateReleaseEnd($year),
                $additionalSql
            );
        }
    }

    private function getAdditionalSql($slug)
    {
        $additionalSql = null;

        $entity = $this->entityFinder->discoverBySlug($slug);
        if($entity) {
            $additionalSql = $entity->getTable() . '.id = ' . $entity->id;
        }

        return $additionalSql;
    }

    private function getDateReleaseStart($year)
    {
        return ($year - 1) . '-12-01';
    }

    private function getDateReleaseEnd($year)
    {
        return $year . '-11-30';
    }

    private function isCriteria($slug)
    {
        return $this->entityFinder->isCriteria($slug);
    }

    private function isGoty($slug)
    {
        return $slug == self::GOTY;
    }
}