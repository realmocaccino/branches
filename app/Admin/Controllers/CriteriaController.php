<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\CriteriaRequest;
use App\Admin\Models\Criteria;

class CriteriaController extends BaseController
{
	protected $criteria;

	public function __construct(Criteria $criteria)
	{
		parent::__construct();
		
		$this->criteria = $criteria;
	}

	public function index()
	{
		$this->head->setTitle('Critérios de Avaliação');
		
		return $this->view('criterias.index')->with([
			'criterias' => $this->criteria->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum Critério de Avaliação encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Critério de Avaliação');
		
		return $this->view('criterias.create', [
			'total_criterias' => ($this->criteria->count() + 1)
		]);
	}
	
	public function store(CriteriaRequest $request)
	{
		$this->criteria->create($request->all());
		
		return redirect(route('criterias.index'))->with('message', 'success|Critério de Avaliação criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Critério de Avaliação');
		
		return $this->view('criterias.edit', [
			'criteria' => $this->criteria->find($id),
			'total_criterias' => $this->criteria->count()
		]);
	}
	
	public function update(CriteriaRequest $request, $id)
	{
		$this->criteria->find($id)->update($request->all());
		
		return redirect(route('criterias.index'))->with('message', 'success|Critério de Avaliação atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->criteria->destroy($id);
		
		return response()->json([
			'message' => 'Critério de Avaliação excluído com sucesso!',
		]);
	}
}
