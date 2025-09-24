<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\ClassificationRequest;
use App\Admin\Models\Classification;

class ClassificationController extends BaseController
{
	protected $classification;

	public function __construct(Classification $classification)
	{
		parent::__construct();
		
		$this->classification = $classification;
	}

	public function index()
	{
		$this->head->setTitle('Classificações Indicativas');
		
		return $this->view('classifications.index')->with([
			'classifications' => $this->classification->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Não há classificações indicativas cadastradas']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Classificação Indicativa');
		
		return $this->view('classifications.create');
	}
	
	public function store(ClassificationRequest $request)
	{
		$this->classification->create($request->all());
		
		return redirect(route('classifications.index'))->with('message', 'success|Classificação indicativa criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Classificação Indicativa');
		
		return $this->view('classifications.edit', [
			'classification' => $this->classification->find($id)
		]);
	}
	
	public function update(ClassificationRequest $request, $id)
	{
		$this->classification->find($id)->update($request->all());
		
		return redirect(route('classifications.index'))->with('message', 'success|Classificação indicativa atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->classification->destroy($id);
		
		return response()->json([
			'message' => 'Classificação indicativa excluída com sucesso!',
		]);
	}
}
