<?php
namespace App\Site\Helpers;

use App\Site\Helpers\LanguageHelper;
use App\Site\Models\{Settings, User};

use Illuminate\Support\Facades\{Auth, Cache, Route, Storage, URL};

class Site
{
	public const OFFICIAL_USER_SLUG = 'nota-do-game';

    public static function canShowAd()
    {
        return (bool) (!app()->isLocal() and (new Settings)->get()->advertisements and !optional(Auth::guard('site')->user())->isPremium());
    }

	public static function changeLanguageLink($language)
	{
		$query = [LanguageHelper::CHANGE_LANGUAGE_QUERY => $language];

		if($currentQuery = request()->except(LanguageHelper::CHANGE_LANGUAGE_QUERY)) {
			$query = array_merge($query, $currentQuery);
		}

		return request()->url() . '?' . http_build_query($query);
	}
    
	public static function createTagLink($tag, $entity, $colorClass = 'primary', $class = 'btn')
	{
		return view('site.components.item.tag', [
			'tag' => $tag,
			'entity' => $entity,
			'colorClass' => $colorClass,
			'class' => $class
		]);
	}
	
	public static function filterReviewText($text, $withBreakLines = true)
	{
		if($withBreakLines) {
			$text = preg_replace("/(\r?\n){3,}/", "\n\n", $text);
		} else {
			$text = preg_replace("/\r|\n/", " ", $text);
		}
		$text = ucfirst(trim(stripslashes($text)));
		
		return $text;
	}

	public static function getCategoryThumbnail($entity, $slug)
	{
		$prefix = config('site.categories_thumbnail_cache_prefix');

		return Cache::get(
			sprintf('%s%s_%s', $prefix, $entity, $slug)
		);
	}
	
	public static function getCompiledFilename($folder)
	{
		$extension = $folder;
		$matches = preg_grep("/^$folder\/all_.*\.$extension$/", Storage::disk('public_site')->files($folder));

		return ($matches) ? $matches[0] : null;
	}

	public static function getOfficialUser()
    {
        return User::findBySlugOrFail(self::OFFICIAL_USER_SLUG);
    }
	
	public static function getPreviousRouteName()
	{
		return Route::getRoutes()->match(app('request')->create(URL::previous()))->getName();
	}
	
	public static function isGamePage($route = null)
	{
		if(!$route) $route = Route::currentRouteName();
		
		return preg_match('/^game.*$/', $route);
	}

	public static function isOfficialUser(User $user)
    {
        return $user->is(self::getOfficialUser());
    }
	
	public static function isPageFiltered()
	{
	    $request = request()->all();
	    unset($request['order'], $request['page']);
	    
	    return (bool) count($request);
	}
	
	public static function tagLinkCollection($tag, $collection, $colorClass = 'primary', $class = 'btn')
	{
		$links = [];
		
		foreach($collection as $entity) {
			$links[] = trim(self::createTagLink($tag, $entity, $colorClass, $class));
		}
		
		return $links ? implode(' ', $links) : null;
	}
}