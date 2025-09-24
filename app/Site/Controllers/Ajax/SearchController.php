<?php
namespace App\Site\Controllers\Ajax;

use App\Site\Helpers\Search;

use Illuminate\Http\Request;

class SearchController extends BaseController
{
	protected $limit;
	protected $search;

	public function __construct(Search $search)
	{
		parent::__construct();

		$this->limit = $this->agent->isMobile() ? config('site.search_results_mobile') : config('site.search_results');
		$this->search = $search;
	}

	public function games(Request $request)
	{
		if($term = $request->term) {
			$this->search->setTerm($term)->perPage($this->limit);
		}
		
		return $this->view('layouts.main.header_search_results', [
			'term' => $term,
			'games' => $term ? $this->search->get() : [],
			'total' => $term ? $this->search->count() : 0
		]);
	}
}