<?php
namespace App\Site\Controllers;

use App\Common\Events\NewCollectionEvent;
use App\Site\Helpers\{Filter, Site};
use App\Site\Models\{Game, User, WarnMe};
use App\Site\Requests\Collection\EditRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends BaseController
{
	protected $filter;
	protected $perPage;
	protected $request;
	protected $game;
	protected $user;

	public function __construct(Filter $filter, Request $request)
	{
		parent::__construct();

		$this->filter = $filter;
		$this->perPage = config('site.per_page');
		$this->request = $request;
		$this->game = $request->gameSlug ? Game::findBySlugOrFail($request->gameSlug) : null;

		$this->middleware(function($request, $next) {
			$this->user = Auth::guard('site')->user();
			
			return $next($request);
		});
	}
	
	public function index()
	{
	    $user = User::findBySlugOrFail($this->request->userSlug);
	    $collection = $user->collections()->whereSlug($this->request->collectionSlug)->firstOrFail();
	    
	    if($collection->private and !$user->is($this->user)) {
	        return redirect()->route('home')->with('alert', 'info|Coleção é privada');
	    }

		$this->head->setTitle($collection->name . trans('collections/collection.by') . $user->name);
		$this->head->setDescription($collection->games()->count() . ' ' . str_plural(trans('collections/collection.game'), $collection->games()->count()));
		$this->head->setInternalTitle($collection->name . ($collection->user->is($this->user) ? $this->view('collection.inc.buttons', [
            'collection' => $collection
        ]) : null));

		$games = $collection->games()->orderByRaw('games.total_ratings + games.total_reviews DESC');
		$this->filter->setQuery($games);

		if(!$isMosaic = $this->request->get('mosaic')) {
			$this->filter->perPage($this->perPage);
		}
		$this->filter->prepare();

		if($cover = $this->filter->getCover('250x')) {
			$this->head->setImage($cover, 250, 250);
		}

		return $this->view('listing.games', [
		    'user' => $user,
		    'collection' => $collection,
		    'isMosaic' => $isMosaic,
		    'removeFromCollection' => $collection->user->is($this->user),
			//'filter' => $this->filter->getBars(),
			'items' => $this->filter->get(),
			'total' => $this->filter->count()
		]);
	}
	
	public function deletePage(Request $request)
	{
	    $this->head->setTitle(trans('collection/delete.title'));
	
	    $collection = $this->user->collections()->whereSlug($request->collectionSlug)->firstOrFail();
	    
	    return $this->view('collection.delete', [
		    'collection' => $collection
		]);
	}
    
    public function editPage(Request $request)
	{
	    $this->head->setTitle(trans('collection/edit.title'));

	    $collection = $this->user->collections()->whereSlug($request->collectionSlug)->firstOrFail();
	    
	    return $this->view('collection.edit', [
		    'collection' => $collection
		]);
	}
	
	public function orderPage()
    {
	    $collection = $this->user->collections()->whereSlug($this->request->collectionSlug)->firstOrFail();

        $this->head->setTitle(trans('collection/order.title') . $collection->name);
        $this->head->addScript('sortable.min.js');

        return $this->view('collection.order', [
            'collection' => $collection
        ]);
    }

    public function add()
    {
        $collection = $this->user->collections()->whereSlug($this->request->collectionSlug)->firstOrFail();
        $collection->games()->syncWithoutDetaching($this->game->id);
        $collection->touch();

        if($collection->isWishlist()) {
			$this->createWarnMeIfGameIsNotAvailableYet();
		}

		if($this->isEligibleToFireEvent($collection)) {
			event(new NewCollectionEvent($collection));
		}

		$message = 'Jogo adicionado à ' . $collection->name;

		return $this->getResponse($message, $collection->isCustom());
    }
    
    public function create()
    {
        $collection = $this->user->createCollection($this->request->name);
        $collection->games()->syncWithoutDetaching($this->game->id);
        $message = 'Coleção criada com sucesso';
        
        return $this->getResponse($message, true);
    }
    
    public function delete(Request $request)
	{
	    $collection = $this->user->collections()->whereSlug($request->collectionSlug)->firstOrFail();
	    
	    $collection->games()->detach();
	    $collection->delete();
	    
	    return redirect()->route('account.collections')->with('alert', 'info|Coleção excluída com sucesso.');
	}
	
	public function edit(EditRequest $request)
	{
	    $collection = $this->user->collections()->whereSlug($request->collectionSlug)->firstOrFail();
	    
	    $collection->name = $request->name;
	    $collection->slug = str_slug($request->name);
	    $collection->private = $request->private;
	    $collection->save();
	    
	    return redirect()->route('collection.index', [$this->user->slug, $collection->slug])->with('alert', 'success|Coleção atualizada com sucesso.');
	}
    
    public function order()
    {
        $collection = $this->user->collections()->whereSlug($this->request->collectionSlug)->firstOrFail();
    
        $sync = [];
        foreach($this->request->items as $item) {
            $sync[$item[0]] = [
                'order' => $item[1]
            ];
        }
        
        $collection->games()->sync($sync);
    }
    
    public function remove()
    {
        $collection = $this->user->collections()->whereSlug($this->request->collectionSlug)->firstOrFail();
        $collection->games()->detach($this->game->id);
        $message = 'Jogo removido de ' . $collection->name;

        return $this->getResponse($message, $collection->isCustom());
    }

    private function createWarnMeIfGameIsNotAvailableYet()
    {
        if(!$this->game->isAvailable()) {
            $warn = new WarnMe;
            $warn->game_id = $this->game->id;
            $warn->user_id = $this->user->id;
            $warn->save();
        }
    }

	private function isEligibleToFireEvent($collection)
	{
		return $collection->isCustom() and $collection->isPublic() and $collection->games()->count() == config('site.minimun_collection_games_to_fire_event');
	}
    
    private function getResponse($message, $isCustom = false)
    {
        if($this->request->ajax()) {
            if($this->user) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'content' => $this->game->getCollectionButtons($this->user),
                    'isCustom' => $isCustom
                ]);
            } else {
                return response()->json([
                    'error' => 'not_logged_in',
                    'loginURL' => route('login.ajax.index')
                ]);
            }
		} else {
		    if(Site::getPreviousRouteName() == 'collection.index') {
		        $redirect = redirect()->route('collection.index', [$this->user->slug, $this->request->collectionSlug]);
		    } else {
                $redirect = redirect()->route('game.index', $this->game->slug);
            }
            
            return $redirect->with('alert', 'success|' . $message);
		}
    }
}