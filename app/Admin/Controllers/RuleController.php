<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\RuleRequest;
use App\Admin\Models\Rule;

class RuleController extends BaseController
{
	protected $rule;

	public function __construct(Rule $rule)
	{
		parent::__construct();
		
		$this->rule = $rule;
	}

	public function index()
	{
		$this->head->setTitle('Regulamentos');
		
		return $this->view('rules.index')->with([
			'rules' => $this->rule->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum regulamento encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Regulamento');
		
		return $this->view('rules.create');
	}
	
	public function store(RuleRequest $request)
	{
		$this->rule->create($request->all());
		
		return redirect(route('rules.index'))->with('message', 'success|Regulamento criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Regulamento');
		
		return $this->view('rules.edit', [
			'rule' => $this->rule->find($id)
		]);
	}
	
	public function update(RuleRequest $request, $id)
	{
		$this->rule->find($id)->update($request->all());
		
		return redirect(route('rules.index'))->with('message', 'success|Regulamento atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->rule->destroy($id);
		
		return response()->json([
			'message' => 'Regulamento excluído com sucesso!',
		]);
	}
}
