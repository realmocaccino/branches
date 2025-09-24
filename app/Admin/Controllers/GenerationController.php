<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\GenreRequest;
use App\Admin\Models\Generation;

class GenerationController extends BaseController
{
	protected $generation;

	public function __construct(Generation $generation)
	{
		parent::__construct();
		
		$this->generation = $generation;
	}

	public function index()
	{
		$this->head->setTitle('Gerações');
		
		return $this->view('generations.index')->with([
			'generations' => $this->generation->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum geração encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Geração');
		
		return $this->view('generations.create');
	}
	
	public function store(GenreRequest $request)
	{
		$this->generation->create($request->all());
		
		return redirect(route('generations.index'))->with('message', 'success|Geração criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Geração');
		
		return $this->view('generations.edit', [
			'generation' => $this->generation->find($id)
		]);
	}
	
	public function update(GenreRequest $request, $id)
	{
		$this->generation->find($id)->update($request->all());
		
		return redirect(route('generations.index'))->with('message', 'success|Geração atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->generation->destroy($id);
		
		return response()->json([
			'message' => 'Geração excluída com sucesso!',
		]);
	}
}
