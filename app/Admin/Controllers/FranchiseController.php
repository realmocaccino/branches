<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\FranchiseRequest;
use App\Admin\Models\Franchise;

class FranchiseController extends BaseController
{
	protected $franchise;

	public function __construct(Franchise $franchise)
	{
		parent::__construct();
		
		$this->franchise = $franchise;
	}

	public function index()
	{
		$this->head->setTitle('Franquias');
		
		return $this->view('franchises.index')->with([
			'franchises' => $this->franchise->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma franquia encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Franquia');
		
		return $this->view('franchises.create');
	}
	
	public function store(FranchiseRequest $request)
	{
		$this->franchise->create($request->all());
		
		return redirect(route('franchises.index'))->with('message', 'success|Franquia criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Franquia');
		
		return $this->view('franchises.edit', [
			'franchise' => $this->franchise->find($id)
		]);
	}
	
	public function update(FranchiseRequest $request, $id)
	{
		$this->franchise->find($id)->update($request->all());
		
		return redirect(route('franchises.index'))->with('message', 'success|Franquia atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->franchise->destroy($id);
		
		return response()->json([
			'message' => 'Franquia excluída com sucesso!',
		]);
	}
}
