<?php
namespace App\Common\Helpers;

use App\Site\Models\{Characteristic, Game, Genre, Theme};

class TagsFiltering
{
    protected $game;

    private const CHARACTERISTICS = 'characteristics';
    private const GENRES = 'genres';
    private const THEMES = 'themes';

    private $conflicts = [
    'characteristics' => [
        [
            'conflict' => ['isometric', 'top-down'],
            'solution' => 'isometric'
        ],
        [
            'conflict' => ['beat-em-up', 'shoot-em-up'],
            'solution' => 'shoot-em-up'
        ],
        [
            'conflict' => ['metroidvania', 'open-world'],
            'solution' => 'metroidvania'
        ],
        [
            'conflict' => ['sandbox', 'open-world'],
            'solution' => 'sandbox'
        ]
        ],
    'genres' => [
        [
            'conflict' => ['action', 'adventure'],
            'solution' => 'action'
        ],
        [
            'conflict' => ['action', 'fighting'],
            'solution' => 'fighting'
        ],
        [
            'conflict' => ['action', 'rpg'],
            'solution' => 'action-rpg'
        ],
        [
            'conflict' => ['action-rpg', 'action-adventure'],
            'solution' => 'action-rpg'
        ],
        [
            'conflict' => ['action-rpg', 'action'],
            'solution' => 'action-rpg'
        ],
        [
            'conflict' => ['action-rpg', 'rpg'],
            'solution' => 'action-rpg'
        ],
        [
            'conflict' => ['action-rpg', 'platform'],
            'solution' => 'action-rpg'
        ],
        [
            'conflict' => ['action-adventure', 'action'],
            'solution' => 'action-adventure'
        ],
        [
            'conflict' => ['action-adventure', 'adventure'],
            'solution' => 'action-adventure'
        ],
        [
            'conflict' => ['action-adventure', 'platform'],
            'solution' => 'action-adventure'
        ],
        [
            'conflict' => ['action', 'first-person-shooter'],
            'solution' => 'first-person-shooter'
        ],
        [
            'conflict' => ['action', 'third-person-shooter'],
            'solution' => 'third-person-shooter'
        ],
        [
            'conflict' => ['adventure', 'first-person-shooter'],
            'solution' => 'first-person-shooter'
        ],
        [
            'conflict' => ['simulation', 'first-person-shooter'],
            'solution' => 'first-person-shooter'
        ],
        [
            'conflict' => ['simulation', 'third-person-shooter'],
            'solution' => 'third-person-shooter'
        ],
        [
            'conflict' => ['sports', 'first-person-shooter'],
            'solution' => 'first-person-shooter'
        ],
        [
            'conflict' => ['sports', 'third-person-shooter'],
            'solution' => 'third-person-shooter'
        ],
        [
            'conflict' => ['sports', 'racing'],
            'solution' => 'racing'
        ]
    ],
    'themes' => [
        [
            'conflict' => ['fantasy', 'martial-arts'],
            'solution' => 'martial-arts'
        ],
        [
            'conflict' => ['fantasy', 'science-fiction'],
            'solution' => 'science-fantasy'
        ],
        [
            'conflict' => ['fantasy', 'science-fantasy'],
            'solution' => 'science-fantasy'
        ],
        [
            'conflict' => ['fantasy', 'dark-fantasy'],
            'solution' => 'dark-fantasy'
        ],
        [
            'conflict' => ['fantasy', 'mythology'],
            'solution' => 'mythology'
        ],
        [
            'conflict' => ['cyberpunk', 'science-fiction'],
            'solution' => 'cyberpunk'
        ],
        [
            'conflict' => ['steampunk', 'science-fiction'],
            'solution' => 'steampunk'
        ],
        [
            'conflict' => ['modern-war', 'warfare'],
            'solution' => 'modern-war'
        ]
    ]
    ];

    public function setGame(Game $game)
    {
        $this->game = $game;
        $this->game->timestamps = false;

        return $this;
    }

    public function handleAllAndSync()
    {
        $this->handleGenresThenSync();
        $this->handleCharacteristicsThenSync();
        $this->handleThemesThenSync();

        return $this;
    }

    public function handleCharacteristicsThenSync($slugs = [])
    {
        $this->syncCharacteristics($this->handleCharacteristics($slugs));

        return $this;
    }

    public function handleGenresThenSync($slugs = [])
    {
        $this->syncGenres($this->handleGenres($slugs));

        return $this;
    }

    public function handleThemesThenSync($slugs = [])
    {
        $this->syncThemes($this->handleThemes($slugs));

        return $this;
    }

    private function handleCharacteristics($slugs = [])
    {
        return $this->filter($slugs, self::CHARACTERISTICS);
    }

    private function handleGenres($slugs = [])
    {
        return $this->filter($slugs, self::GENRES);
    }

    private function handleThemes($slugs = [])
    {
        return $this->filter($slugs, self::THEMES);
    }

    private function syncCharacteristics($slugs)
    {
        $this->game->characteristics()->sync(Characteristic::whereIn('slug', $slugs)->pluck('id'));
    }

    private function syncGenres($slugs)
    {
        $this->game->genres()->sync(Genre::whereIn('slug', $slugs)->pluck('id'));
    }

    private function syncThemes($slugs)
    {
        $this->game->themes()->sync(Theme::whereIn('slug', $slugs)->pluck('id'));
    }

    private function filter($slugs = [], $relationship)
    {
        $slugs = $this->mergeSlugsWithOnesAlreadySaved($relationship, $slugs);
        $slugs = $this->removeDuplicates($slugs);
        $slugs = $this->resolveConflicts($relationship, $slugs);

        if($relationship === self::CHARACTERISTICS) {
            $slugs = $this->removeRedundantSlugs($slugs);
        }

        return $slugs;
    }

    private function mergeSlugsWithOnesAlreadySaved($relationship, $slugs = [])
    {
        return array_merge($this->game->$relationship->pluck('slug')->toArray(), $slugs);
    }

    private function removeDuplicates($slugs) {
        return array_unique($slugs);
    }

    private function resolveConflicts($relationship, $slugs) {
        foreach ($this->conflicts[$relationship] as $conflict) {
            $conflictSlugs = $conflict['conflict'];
            $solution = $conflict['solution'];
            if (count(array_intersect($slugs, $conflictSlugs)) >= count($conflictSlugs)) {
                $slugs = array_diff($slugs, $conflictSlugs);
                $slugs[] = $solution;
            }
        }

        return $slugs;
    }

    private function removeRedundantSlugs($slugs)
    {
        foreach($slugs as $key => $slug) {
            foreach($this->game->genres->pluck('slug') as $genreSlug) {
                if(str_contains($genreSlug, $slug)) unset($slugs[$key]);
            }
        }
        
        return array_values($slugs);
    }
}