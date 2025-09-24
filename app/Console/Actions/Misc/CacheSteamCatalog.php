<?php
namespace App\Console\Actions\Misc;

use App\Console\Exceptions\UrlNotFoundException;

use Exception;
use Illuminate\Support\Facades\Cache;

class CacheSteamCatalog
{
    public const CACHE_NAME = 'steam_catalog';
    private const CACHE_DURATION = 60 * 60 * 24;

    private const CATALOG_URI = 'http://api.steampowered.com/ISteamApps/GetAppList/v0002/';

    private const FULL_IRRELEVANT_CHARACTERS = [
        ' ', ':', ';', ',', '.', '-', '_',
        '+', '*', '/', '\\', '|', '(', ')',
        '[', ']', '{', '}'
    ];
    private const TERMS_TO_DISCARD = [
        'Alpha',
        'Beta',
        'Bundle',
        'Crossplay',
        'Demo',
        'Dlc',
        'Edition',
        'Expansion',
        'Key',
        'Pack',
        'Playtest',
        'Pre-Order',
        'Pre-Purchase',
        'Season Pass',
        'Skin',
        'Soundtrack',
        'Update',
        'Upgrade'
    ];

    public function run()
    {
        $this->checkUrl();

        $array = json_decode(file_get_contents(self::CATALOG_URI), true);

        if(isset($array['applist']['apps'])) {
            $apps = array_column($array['applist']['apps'], 'name', 'appid');
            $validApps = [];

            foreach($apps as $id => $name) {
                if(!$this->containDiscardedTerm($name)) {
                    $validApps[$id] = $name;
                }
            }

            return $this->cache($validApps);
        }

        return new Exception('Nenhum app encontrado');
    }

    private function cache($apps)
    {
        Cache::store('file')->forget(self::CACHE_NAME);
        Cache::store('file')->put(self::CACHE_NAME, $apps, self::CACHE_DURATION);
    }
    
    private function checkUrl()
	{
		if(!curl_init(self::CATALOG_URI)) throw new UrlNotFoundException('URL não está disponível');
	}

    private function containDiscardedTerm($name)
    {
        foreach(self::TERMS_TO_DISCARD as $term) {
            if (stripos($name, $term) !== false &&
                (stripos($name, ' ' . $term . ' ') !== false ||
                stripos($name, ' ' . $term) === 0 ||
                stripos($name, $term . ' ') === (strlen($name) - strlen($term) - 1))) {
                return true;
            }

            foreach (self::FULL_IRRELEVANT_CHARACTERS as $char) {
                if (stripos($name, $char . $term) !== false ||
                    stripos($name, $term . $char) !== false) {
                    return true;
                }
            }
        }

        return false;
    }
}