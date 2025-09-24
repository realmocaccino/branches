<?php
namespace App\Site\Controllers;

use App\Site\Models\Rule;

class RuleController extends BaseController
{
	protected $rule;

	public function __construct(Rule $rule)
	{
		parent::__construct();
		
		$this->rule = $rule;
	}
	
	public function index($page)
	{
		$rule = $this->rule->findBySlugOrFail($page);
		
		$this->head->setTitle($rule->title);
		$this->head->setDescription($rule->description);
		
		return $this->view('rule.index', [
			'text' => $rule->text
		]);
	}
}