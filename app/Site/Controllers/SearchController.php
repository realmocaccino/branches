<?php
namespace App\Site\Controllers;

use App\Site\Helpers\{Filter, Search};

use Illuminate\Http\Request;

class SearchController extends BaseController
{
	protected $filter;
	protected $search;

	protected $perPage;
	protected $perPageUser;

	public function __construct(Filter $filter, Search $search)
	{
		parent::__construct();
		
		$this->filter = $filter;
		$this->search = $search;

		$this->perPage = $this->getConfiguration('per_page');
		$this->perPageUser = $this->getConfiguration('per_page_user');
	}

	public function games(Request $request)
	{
		if(!$term = $request->term) {
			abort(404);
		}

		$this->head->setTitle(trans('search/index.title_games') . '"' . $term . '"');
		
		$this->filter->setQuery($this->search->setTerm($term)->getQuery())->perPage($this->perPage)->prepare();

		if($cover = $this->filter->getCover('250x')) {
			$this->head->setImage($cover, 250, 250);
		}
		
		return $this->view('listing.games', [
			//'filter' => $this->filter->getBars(),
			'items' => $this->filter->get(),
			'total' => $this->filter->count(),
			'term' => $term
		]);
	}
	
	public function users(Request $request)
	{
		if(!$term = $request->term) {
			abort(404);
		}

		$this->head->setTitle(trans('search/index.title_users') . '"' . $term . '"');
		$this->head->disableSearchIndexing();

		$this->search->fromUsers()->setTerm($term)->perPage($this->perPageUser);
		
		return $this->view('listing.users', [
		    'total' => $this->search->count(),
			'items' => $this->search->get()
		]);
	}
}