<?php
namespace App\Site\Controllers;

use App\Site\Helpers\HomeHelper;

class HomeController extends BaseController
{
	private $homeHelper;
	private $perPage;

    public function __construct(HomeHelper $homeHelper)
    {
        parent::__construct();

        $this->homeHelper = $homeHelper;
		$this->perPage = $this->getConfiguration('per_page');
    }

	public function index()
	{
		$list = $this->homeHelper->getListFromCacheOrBuildIt($this->perPage);

		return $this->view('listing.games', [
			//'filter' => $this->agent->isMobile() ? $list->getBars() : $list->getBarsWithAlphabet(),
			'items' => $list->get(),
			'total' => $list->count()
		]);
	}
}