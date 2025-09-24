<?php
namespace App\Site\Middlewares;

use App\Site\Models\Game;

use Closure;

class CheckGameAvailability
{
	public function handle($request, Closure $next, $gameSlug)
    {
    	$game = Game::findBySlugOrFail($request->gameSlug);
    	
        if($game->isAvailable()) {
        	return $next($request);
        } else {
        	return redirect()->route('home')->with('alert', 'warning|Jogo ainda não disponível para avaliação');
		}
    }
}
