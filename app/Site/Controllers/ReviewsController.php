<?php
namespace App\Site\Controllers;

use App\Site\Helpers\Filter;
use App\Site\Models\Rating;

class ReviewsController extends BaseController
{
	protected $filter;
	protected $perPage;

	public function __construct(Filter $filter)
	{
		parent::__construct();
		
		$this->filter = $filter;
		$this->perPage = config('site.reviews_per_page');;
	}

	public function index()
	{
		$this->head->setTitle(trans('reviews/index.title'));

		$this->filter->setQuery(Rating::has('review')->latest())->perPage($this->perPage)->areRatings()->prepare();
		
		return $this->view('listing.reviews', [
			'filter' => $this->filter->getBars(),
			'items' => $this->filter->get($simplePagination = true),
			'total' => $this->filter->count()
		]);
	}
}