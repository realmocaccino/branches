<?php
namespace App\Site\Helpers;

use App\Common\Helpers\EntityFinder;

class TagHelper
{
    private const LIST_SLUG = 'featured-games';
	private const LIST_SLUG_CRITERIA = 'with-criteria';

    private $entityFinder;
    private $listHelper;

    public function __construct(EntityFinder $entityFinder, ListHelper $listHelper)
    {
        $this->entityFinder = $entityFinder;
        $this->listHelper = $listHelper;
    }

    public function getTitle($tag, $slug)
    {
        if($this->isYear($tag)) {
            return trans('tag/index.games_from') . $slug;
        } elseif($entity = $this->entityFinder->getModelInstanceByString($tag)->findBySlugOrFail($slug)) {
            return trans('tag/index.games_from') . $entity->name;
        }

        return null;
    }

    public function getList($tag, $slug, $perPage)
    {
        return $this->listHelper
        ->setSlug($this->isCriteria($tag) ? self::LIST_SLUG_CRITERIA : self::LIST_SLUG)
        ->setPlatform($this->isPlatform($tag) ? $slug : null)
        ->withFurtherExpression($this->getFurtherExpression($tag, $slug))
        ->perPage($perPage)
        ->getWithFilter();
    }

    private function isCriteria($tag)
    {
        return $tag === 'criteria';
    }

    private function isPlatform($tag)
    {
        return $tag === 'platform';
    }

    private function isYear($tag)
    {
        return $tag === 'year';
    }

    private function getCriteriaExpression($entity)
    {
        return function($query) use($entity) {
            return $query->where('criterias.slug', $entity->slug);
        };
    }

    private function getEntityExpression($entity)
    {
        return function($query) use($entity) {
            return $query->whereHas($entity->getTable(), function($query) use($entity) {
                return $query->where('slug', $entity->slug);
            });
        };
    }

    private function getFurtherExpression($tag, $slug)
    {
        if($this->isYear($tag)) {
            return $this->getYearExpression($slug);
        } elseif($entity = $this->entityFinder->getModelInstanceByString($tag)->findBySlugOrFail($slug)) {
            if($this->isCriteria($tag)) {
                return $this->getCriteriaExpression($entity);
            }

            return $this->getEntityExpression($entity);
        }

        return abort(404);
    }

    private function getYearExpression($year)
    {
        return function($query) use($year) {
            return $query->whereYear('games.release', $year);
        };
    }
}