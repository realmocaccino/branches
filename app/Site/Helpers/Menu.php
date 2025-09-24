<?php
namespace App\Site\Helpers;

use App\Site\Models\Menu as MenuModel;

use Illuminate\Support\Facades\Route;

class Menu
{
	public static function show($menuSlug, $classes = [], $separator = '')
	{
		$menu = MenuModel::whereSlug($menuSlug)->whereStatus(1)->first();
		
		if($menu) {
			$classes = implode(' ', $classes);
			$links = $menu->links()->whereStatus(1)->orderByRaw('`order` + 0')->get();
			
			$itens = [];
			foreach($links as $link) {
				if(Route::has($link->route)) {
					$parameters = $link->parameters ? array_map('trim', explode(',', $link->parameters)) : [];
					$itens[] = Self::view($link, $parameters, $classes);
				}
			}
			
			return implode($separator, $itens);
		}
		
		return null;
	}
	
	private static function view($link, $parameters = [], $classes = null)
	{
		return view('site.helpers.menu.link', [
			'link' => $link,
			'url' => !$parameters ? route($link->route) : route($link->route, $parameters),
			'current' => self::isCurrentRoute($link, $parameters),
            'classes' => $classes
		]);
	}

	private static function isCurrentRoute($link, $parameters)
	{
		return (bool) (Route::currentRouteName() == $link->route and $route = request()->route() and $parameters == array_values($route->parameters));
	}
}
