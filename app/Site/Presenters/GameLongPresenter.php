<?php
namespace App\Site\Presenters;

use App\Site\Models\{Game, User};
use App\Site\Helpers\RankingHelper;

use Illuminate\Support\Facades\DB;

trait GameLongPresenter
{
    public function getCollectionButtons(User $user = null)
    {
		$addedToPlaying = false;
        $favorited = false;
        $wishlisted = false;
        $userCustomCollections = [];
        $totalInCollections = 0;
		$totalPlaying = $this->collections()->whereSlug('playing')->count();
        $totalFavorites = $this->collections()->whereSlug('favorites')->count();
        $totalInWishlist = $this->collections()->whereSlug('wishlist')->count();
        
        if($user) {
			$addedToPlaying = $user->playingGames()->where('games.id', $this->id)->exists();
            $favorited = $user->favoriteGames()->where('games.id', $this->id)->exists();
            $wishlisted = $user->wishlistGames()->where('games.id', $this->id)->exists();
            $userCustomCollections = $user->collections()->onlyCustom()->get()->map(function($collection) {
                $collection['isGameInTheCollection'] = $collection->games()->where('games.id', $this->id)->exists();

                return $collection;
            });
            $totalInCollections = $userCustomCollections->where('isGameInTheCollection', true)->count() + $addedToPlaying + $favorited + $wishlisted;
        }

        return view('site.game.components.buttonsTooltip', [
            'game' => $this,
			'addedToPlaying' => $addedToPlaying,
            'favorited' => $favorited,
            'wishlisted' => $wishlisted,
            'userCustomCollections' => $userCustomCollections,
            'totalInCollections' => $totalInCollections,
			'totalPlaying' => $totalPlaying,
            'totalFavorites' => $totalFavorites,
            'totalInWishlist' => $totalInWishlist
        ])->render();
    }

	public function getRankingPosition()
	{
        $position = null;
        $minimumToRank = config('site.minimum_ratings_to_rank');

        if($this->total_ratings >= $minimumToRank) {
            $position = resolve(RankingHelper::class)->getGamesRanking($this->release->year)
                    ->where(function ($query) {
                        return $query->where('score', '>', function ($query) {
                            return $query->select('score')->from('games')->where('id', $this->id);
                        })->orWhere(function ($query) {
                            return $query->where('score', function ($query) {
                                return $query->select('score')->from('games')->where('id', $this->id);
                            })->where('total_ratings', '>', function ($query) {
                                return $query->select('total_ratings')->from('games')->where('id', $this->id);
                            });
                        });
                    })->count() + 1 . 'º';
        }

        return $position;
	}
	
	public function getRankingGames($limit = 7)
    {
        $games = [];

        if($this->isAvailable() and $this->canRank()) {
            $games = resolve(RankingHelper::class)->getGamesRanking($this->release->year)->take($limit)->get();
            for($i = 0; $i < count($games); $i++) {
                $games[$i]->position = ($i + 1) . '°';
            }
            if(!$games->contains('id', $this->id)) {
                $this->position = $this->getRankingPosition() ?? '-';
                $games->pop();
                $games->push($this);
            }
        }
        
        return $games;
    }
	
	public function summedUpGenres()
	{
		$genres = $this->genres()->pluck('name', 'slug')->all();
		
		if($genres) {
			if(isset($genres['acao'], $genres['aventura'])) {
				$genres['acao-aventura'] = 'Ação-Aventura';
				
				unset($genres['acao'], $genres['aventura']);
			}
			
			if(isset($genres['combate-aereo'], $genres['combate-veicular'])) {
				$genres['combate-aereo-e-veicular'] = 'Combate Aéreo e Veícular';
				
				unset($genres['combate-aereo'], $genres['combate-veicular']);
			}
			
			if(isset($genres['construcao'], $genres['gerenciamento'])) {
				$genres['construcao-e-gerenciamento'] = 'Construção e Gerenciamento';
				
				unset($genres['construcao'], $genres['gerenciamento']);
			}
			
			if(isset($genres['estrategia-em-tempo-real'], $genres['estrategia-por-turnos'])) {
				$genres['estrategia-em-tempo-real-e-por-turnos'] = 'Estratégia em Tempo Real e por Turnos';
				
				unset($genres['estrategia-em-tempo-real'], $genres['estrategia-por-turnos']);
			}
			
			if(isset($genres['mmo'], $genres['rpg'])) {
				$genres['mmorpg'] = 'MMORPG';
				
				unset($genres['mmo'], $genres['rpg']);
			}
			
			if(isset($genres['primeira-pessoa'], $genres['terceira-pessoa'])) {
				$genres['primeira-e-terceira-pessoa'] = 'Primeira e Terceira Pessoa';
				
				unset($genres['primeira-pessoa'], $genres['terceira-pessoa']);
			}
			
			if(isset($genres['taticas-em-tempo-real'], $genres['taticas-por-turnos'])) {
				$genres['taticas-em-tempo-real-e-por-turnos'] = 'Táticas em Tempo Real e por Turnos';
				
				unset($genres['taticas-em-tempo-real'], $genres['taticas-por-turnos']);
			}
			
			if(isset($genres['terror-psicologico'], $genres['terror-de-sobrevivencia'])) {
				$genres['terro-psicologico-e-de-sobrevivencia'] = 'Terror Psicológico e de Sobrevivência';
				
				unset($genres['terror-psicologico'], $genres['terror-de-sobrevivencia']);
			}
			
			if(isset($genres['tiro-em-primeira-pessoa'], $genres['tiro-em-terceira-pessoa'])) {
				$genres['tiro-em-primeira-e-terceira-pessoa'] = 'Tiro em Primeira e Terceira Pessoa';
				
				unset($genres['tiro-em-primeira-pessoa'], $genres['tiro-em-terceira-pessoa']);
			}
			
			foreach(['primeira-pessoa' => 'Primeira Pessoa', 'terceira-pessoa' => 'Terceira Pessoa'] as $personSlug => $personName) {
				if(isset($genres[$personSlug])) {
					unset($genres[$personSlug]);
					
					$personGenre = array_shift($genres) . ' em ' . $personName;
					$genres[str_slug($personGenre)] = $personGenre;
				}
			}
			
			asort($genres);
			
			return $genres;
		}
	}
	
	public function summedUpModes()
	{
		$modes = $this->modes->pluck('name', 'slug')->all();
		
		if($modes) {
			if(isset($modes['couch-co-op'], $modes['online-co-op'])) {
				$modes['couch-and-online-co-op'] = 'Cooperativo Local e Online';
				
				unset($modes['couch-co-op'], $modes['online-co-op']);
			}
			
			if(isset($modes['local-competitive'], $modes['online-competitive'])) {
				$modes['local-and-online-competitive'] = 'Competitivo Local e Online';
				
				unset($modes['local-competitive'], $modes['online-competitive']);
			}
		}

		return $modes;
	}
	
	public function relateds($limit = null)
	{
		return collect();
		
		$relations = [
		    'characteristic',
			'genre',
			'theme',
			'developer',
			'platform'
		];
	
		$unions = [];
		
		foreach($relations as $relation) {
			switch($relation) {
				case 'characteristic':
					$characteristics_ids = $this->characteristics()->pluck('characteristics.id')->all();
					
					if($characteristics_ids) {
						$unions[] = "SELECT games.*, 1 AS weight FROM games INNER JOIN characteristic_game ON games.id = characteristic_game.game_id WHERE characteristic_game.characteristic_id IN(" . implode(',',  $characteristics_ids) . ")";
					}
				break;
				case 'developer':
					$developers_ids = $this->developers()->pluck('developers.id')->all();
					
					if($developers_ids) {
						$unions[] = "SELECT games.*, 1 AS weight FROM games INNER JOIN developer_game ON games.id = developer_game.game_id WHERE developer_game.developer_id IN(" . implode(',',  $developers_ids) . ")";
					}
				break;
				case 'franchise':
					$franchises_ids = $this->franchises()->pluck('franchises.id')->all();
				
					if($franchises_ids) {
						$unions[] = "SELECT games.*, 1 AS weight FROM games INNER JOIN franchise_game ON games.id = franchise_game.game_id WHERE franchise_game.franchise_id IN(" . implode(',',  $franchises_ids) . ")";
					}
				break;
				case 'genre':
					$genres_ids = $this->genres()->pluck('genres.id')->all();
				
					if($genres_ids) {
						$unions[] = "SELECT games.*, 1 AS weight FROM games INNER JOIN game_genre ON games.id = game_genre.game_id WHERE game_genre.genre_id IN(" . implode(',',  $genres_ids) . ")";
					}
				break;
				case 'mode':
					$modes_ids = $this->modes()->pluck('modes.id')->all();
				
					if($modes_ids) {
						$unions[] = "SELECT games.*, 1 AS weight FROM games INNER JOIN game_mode ON games.id = game_mode.game_id WHERE game_mode.mode_id IN(" . implode(',',  $modes_ids) . ")";
					}
				break;
				case 'platform':
				    if($this->isExclusive()) {
					    $platforms_ids = $this->platforms()->pluck('platforms.id')->all();
			    
					    if($platforms_ids) {
						    $unions[] = "SELECT games.*, 1 AS weight FROM games INNER JOIN game_platform ON games.id = game_platform.game_id WHERE game_platform.platform_id IN(" . implode(',',  $platforms_ids) . ")";
					    }
					}
				break;
				case 'publisher':
					$publishers_ids = $this->publishers()->pluck('publishers.id')->all();
				
					if($publishers_ids) {
						$unions[] = "SELECT games.*, 1 AS weight FROM games INNER JOIN game_publisher ON games.id = game_publisher.game_id WHERE game_publisher.publisher_id IN(" . implode(',',  $publishers_ids) . ")";
					}
				break;
				case 'theme':
					$themes_ids = $this->themes()->pluck('themes.id')->all();
				
					if($themes_ids) {
						$unions[] = "SELECT games.*, 1 AS weight FROM games INNER JOIN game_theme ON games.id = game_theme.game_id WHERE game_theme.theme_id IN(" . implode(',',  $themes_ids) . ")";
					}
				break;
			}
		}
		
		$dateReference = $this->release ?? today();
		
		if($unions) {
			$relatedGamesIds = DB::table(DB::raw('(' . implode(' UNION ALL ', $unions) . ') AS games'))
			->select(DB::raw("SUM(weight) as weightSum, games.*"))
			->where('games.id', '!=', $this->id)
			->where('games.status', '=', 1)
			->whereNotNull('games.release')
			->whereNull('games.deleted_at')
			->groupBy('games.id')
			->orderBy('weightSum', 'DESC')
			->orderBy(DB::raw("ABS(DATEDIFF(games.release, '{$dateReference}'))"), 'ASC')
			->when($limit, function($query) use($limit) {
			    return $query->take($limit);
			})
			->pluck('games.id')
			->all();

			return ($relatedGamesIds) ? Game::whereIn('id', $relatedGamesIds)->orderByRaw('FIELD (id, ' . implode(',', $relatedGamesIds) . ')')->get() : collect();
		} else {
			return collect();
		}
	}
}