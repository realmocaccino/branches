<?php
namespace App\Site\Controllers;

use App\Site\Helpers\Filter;
use App\Site\Models\Rating;

class RatingsController extends BaseController
{
	protected $filter;
	protected $perPage;

	public function __construct(Filter $filter)
	{
		parent::__construct();
		
		$this->filter = $filter;
		$this->perPage = config('site.ratings_per_page');
	}

	public function index()
	{
		$this->head->setTitle(trans('ratings/index.title'));

		$ratings = Rating::select('ratings.*')
		->join('games', 'games.id', '=', 'ratings.game_id')
		->join('users', 'users.id', '=', 'ratings.user_id')
		->where('games.status', 1)
		->where('users.status', 1)
		->latest();

		$this->filter->setQuery($ratings)->perPage($this->perPage)->areRatings()->prepare();
		
		return $this->view('listing.ratings', [
			'filter' => $this->filter->getBars(),
			'items' => $this->filter->get($simplePagination = true),
			'total' => $this->filter->count()
		]);
	}
}