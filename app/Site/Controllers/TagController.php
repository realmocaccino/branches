<?php
namespace App\Site\Controllers;

use App\Site\Helpers\TagHelper;

class TagController extends BaseController
{
	private $tagHelper;
	private $perPage;

	public function __construct(TagHelper $tagHelper)
    {
        parent::__construct();

		$this->tagHelper = $tagHelper;
		$this->perPage = $this->getConfiguration('per_page');
    }

	public function index($tag, $slug)
	{
		$this->head->setTitle($this->tagHelper->getTitle($tag, $slug));

		$list = $this->tagHelper->getList($tag, $slug, $this->perPage);

		if($cover = $list->getCover('250x')) {
			$this->head->setImage($cover, 250, 250);
		}

		return $this->view('listing.games', [
			//'filter' => $list->getBarsWithAlphabet(),
			'items' => $list->get(),
			'total' => $list->count()
		]);
	}
}