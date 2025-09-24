<?php
namespace App\Site\Controllers;

use App\Site\Models\News;

class NewsController extends BaseController
{
	protected $news;

	public function __construct(News $news)
	{
		parent::__construct();
		
		$this->news = $news;
	}
	
	public function index()
	{
		$this->head->setTitle('Novidades');
		$this->head->setDescription('Confira as novidades do ' . $this->settings->name);
	
		$news = $this->news->latest()->paginate(10);
		
		return $this->view('news.index', [
			'news' => $news
		]);
	}
}
