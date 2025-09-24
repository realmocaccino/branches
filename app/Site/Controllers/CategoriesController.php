<?php
namespace App\Site\Controllers;

use App\Site\Helpers\CategoriesHelper;

class CategoriesController extends BaseController
{
	private $categoriesHelper;

	public function __construct(CategoriesHelper $categoriesHelper)
	{
		parent::__construct();

		$this->categoriesHelper = $categoriesHelper;
	}

	public function index()
	{
		$this->head->setTitle(trans('categories/index.title') . $this->settings->name);

		return $this->view('categories.index', [
			'lists' => $this->categoriesHelper->getSectionFromCache('lists'),
			'years' => $this->categoriesHelper->getSectionFromCache('years'),
			'byScore' => $this->categoriesHelper->getSectionFromCache('byScore'),
			'criterias' => $this->categoriesHelper->getSectionFromCache('criterias'),
			'characteristics' => $this->categoriesHelper->getSectionFromCache('characteristics'),
			'genres' => $this->categoriesHelper->getSectionFromCache('genres'),
			'themes' => $this->categoriesHelper->getSectionFromCache('themes'),
			'modes' => $this->categoriesHelper->getSectionFromCache('modes'),
			'platforms' => $this->categoriesHelper->getSectionFromCache('platforms'),
			'collections' => $this->categoriesHelper->getSectionFromCache('collections'),
		]);
	}
}