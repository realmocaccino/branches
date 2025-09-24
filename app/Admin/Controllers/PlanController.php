<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\PlanRequest;
use App\Admin\Models\Plan;

class PlanController extends BaseController
{
	protected $plan;

	public function __construct(Plan $plan)
	{
		parent::__construct();
		
		$this->plan = $plan;
	}

	public function index($relationship = null, $column = null, $value = null)
	{
		$this->head->setTitle('Planos');
		
		$plans = $this->plan->filter($relationship, $column, $value);
		
		return $this->view('plans.index')->with([
			'plans' => $plans->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum plano encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Plano');
		
		return $this->view('plans.create');
	}
	
	public function store(PlanRequest $request)
	{
		$this->plan->create($request->all());
		
		return redirect(route('plans.index'))->with('message', 'success|Plano criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Plano');
		
		return $this->view('plans.edit', [
			'plan' => $this->plan->find($id),
		]);
	}
	
	public function update(PlanRequest $request, $id)
	{
		$this->plan->find($id)->update($request->all());
		
		return redirect(route('plans.index'))->with('message', 'success|Plano atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->plan->destroy($id);
		
		return response()->json([
			'message' => 'Plano excluído com sucesso!',
		]);
	}
}