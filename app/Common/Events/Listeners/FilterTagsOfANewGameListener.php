<?php
namespace App\Common\Events\Listeners;

use App\Common\Helpers\TagsFiltering;

class FilterTagsOfANewGameListener
{
    protected $tagsFiltering;

    public function __construct(TagsFiltering $tagsFiltering)
    {
        $this->tagsFiltering = $tagsFiltering;
    }

    public function handle($event)
    {
        $this->tagsFiltering->setGame($event->game)->handleAllAndSync();
    }
}