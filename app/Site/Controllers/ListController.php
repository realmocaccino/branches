<?php
namespace App\Site\Controllers;

use App\Site\Helpers\{ListHelper, Filter};

class ListController extends BaseController
{
	protected $filter;
	protected $listHelper;
	protected $perPage;

	public function __construct(Filter $filter, ListHelper $listHelper)
	{
		parent::__construct();
		
		$this->filter = $filter;
		$this->listHelper = $listHelper;
		$this->perPage = config('site.per_page');
	}

	public function index($slug, $platformSlug = null)
	{
		$this->listHelper
		->setSlug($slug)
		->setPlatform($platformSlug);

		$this->filter
		->setQuery($this->listHelper->getQuery());

		if($platformSlug) {
			$this->filter->excludeFilter('platform');
		}
		
		$this->filter->perPage($this->perPage)->prepare();
		
		$this->head->setTitle($this->listHelper->getTitle());

		if($cover = $this->filter->getCover('250x')) {
			$this->head->setImage($cover, 250, 250);
		}
		
		return $this->view('listing.games', [
			//'filter' => $this->filter->getBars(),
			'items' => $this->filter->get(),
			'total' => $this->filter->count(),
			'isExtensiveRelease' => $this->listHelper->isExtensiveRelease()
		]);
	}
}