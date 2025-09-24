<?php
namespace App\Console\Services;

use App\Console\Actions\Misc\CacheSteamCatalog;
use App\Console\Exceptions\NoApiGameFoundException;

use Exception;
use Illuminate\Support\Facades\Cache;

class SteamCatalogService
{
    private $apps = [];

    private function loadApps()
    {
        if(!$this->apps) {
            $cacheApps = Cache::store('file')->get(CacheSteamCatalog::CACHE_NAME);

            if(!$cacheApps) {
                throw new Exception('Catálogo da Steam está vazio');
            }

            $this->apps = $cacheApps;
        }
    }

    public function getAppIdByName($name): int
    {
        $this->loadApps();

        $appId = array_search(
            strtolower($name),
            array_map('strtolower', array_reverse($this->apps, true))
        );

        if(!$appId) throw new NoApiGameFoundException('AppId não encontrado no arquivo de catálogo da Steam');

        return $appId;
    }

    public function provideGamesToChoose($term, $total)
    {
        $this->loadApps();

        $options = [];

        foreach($this->search($term, $total) as $id => $name) {
            $options[] = $this->createOptionRepresentation($id, $name);
        }

        return $options;
    }  

    private function createOptionRepresentation($id, $name)
    {
        return (object) [
            'id' => $id,
            'name' => $name,
            'nameWithReleaseYear' => $name
        ];
    }

    private function search($term, $total)
    {
        if(!$this->apps) throw new Exception('Catálogo da Steam está vazio');

        $exactMatches = preg_grep("/^" . preg_quote($term, '/') . "$/i", $this->apps);
        $partialMatches = array_diff(preg_grep("/\b$term\b/i", $this->apps), $exactMatches);

        return array_slice($exactMatches + $partialMatches, 0, $total, true);
    }
}