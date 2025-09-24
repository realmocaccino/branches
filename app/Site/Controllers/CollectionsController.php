<?php
namespace App\Site\Controllers;

use App\Site\Models\Collection;

use Illuminate\Http\Request;

class CollectionsController extends BaseController
{
    protected $collections;
	protected $perPage;
	protected $request;

	public function __construct(Collection $collection, Request $request)
	{
		parent::__construct();

        $this->collections = $collection->onlyCustom()->notPrivate()->withAtLeastThreeGames()->latest();
		$this->perPage = config('site.collections_per_page');
		$this->request = $request;
	}
	
	public function index()
	{
		$this->head->setTitle(trans('collections/index.title'));

		return $this->view('collections.index', [
		    'total' => $this->collections->count(),
			'collections' => $this->collections->paginate($this->perPage)
		]);
	}
	
	public function search()
	{
		$this->head->setTitle(trans('collections/search.title') . '"' . $this->request->term . '"');
		
		if($this->request->term) {
		    $collections = $this->collections->where('name', 'LIKE', '%' . $this->request->term . '%')->has('user');
		} else {
		    abort(404);
		}
		
		return $this->view('collections.index', [
		    'total' => $collections->count(),
			'collections' => $collections->paginate($this->perPage)->appends($this->request->query())
		]);
	}
}