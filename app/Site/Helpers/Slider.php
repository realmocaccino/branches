<?php
namespace App\Site\Helpers;

class Slider
{
    private static $view = 'site.helpers.slider';

    public static function getComponent($slug, $totalItems)
    {
        $list = resolve(ListHelper::class)->setSlug($slug)->perPage($totalItems);

        return self::hasEnoughItems($list->count()) ? view(self::$view, [
            'items' => $list->get(),
            'title' => $list->getTitle(),
            'slug' => $list->getSlug(),
            'platform' => $list->getPlatform(),
            'coverSize' => '250x',
            'isExtensiveRelease' => $list->isExtensiveRelease()
        ])->render() : null;
    }

    private static function hasEnoughItems($totalItems)
    {
        return $totalItems >= config('site.minimum_items_to_slider');
    }
}