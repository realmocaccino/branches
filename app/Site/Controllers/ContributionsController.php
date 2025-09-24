<?php
namespace App\Site\Controllers;

use App\Site\Models\Contribution;

class ContributionsController extends BaseController
{
    protected $contributions;
	protected $perPage;

	public function __construct(Contribution $contributions)
    {
        parent::__construct();

        $this->contributions = $contributions;
        $this->perPage = $this->getConfiguration('contributions_per_page');
    }

	public function index()
	{
		$this->head->setTitle(trans('contributions/index.title'));

		return $this->view('listing.contributions', [
		    'total' => $this->contributions->count(),
			'items' => $this->contributions->latest()->paginate($this->perPage)
		]);
	}
}