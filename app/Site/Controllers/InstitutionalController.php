<?php
namespace App\Site\Controllers;

use App\Site\Models\Institutional;

class InstitutionalController extends BaseController
{
	protected $institutional;

	public function __construct(Institutional $institutional)
	{
		parent::__construct();
		
		$this->institutional = $institutional;
	}
	
	public function index($page)
	{
		$institutional = $this->institutional->findBySlugOrFail($page);
		
		$this->head->setTitle($institutional->title);
		$this->head->setDescription($institutional->description);
		
		return $this->view('institutional.index', [
			'text' => $institutional->text
		]);
	}
}