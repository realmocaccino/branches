<?php
namespace App\Console\Actions\Misc;

use App\Site\Models\Collection;

class FlushIrrelevantCollections
{
    private const MINIMUM_OF_GAMES = 3;

    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function run()
    {
        $this->collection
        ->onlyCustom()
        ->where('created_at', '<', now()->subMonth())
        ->withCount(['games' => function ($query) {
            return $query->where('games_count', '<', self::MINIMUM_OF_GAMES);
        }])
        ->delete();
    }
}