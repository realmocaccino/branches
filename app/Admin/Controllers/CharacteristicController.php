<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\CharacteristicRequest;
use App\Admin\Models\Characteristic;

class CharacteristicController extends BaseController
{
	protected $characteristic;

	public function __construct(Characteristic $characteristic)
	{
		parent::__construct();
		
		$this->characteristic = $characteristic;
	}

	public function index()
	{
		$this->head->setTitle('Características');
		
		return $this->view('characteristics.index')->with([
			'characteristics' => $this->characteristic->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma característica encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Característica');
		
		return $this->view('characteristics.create');
	}
	
	public function store(CharacteristicRequest $request)
	{
		$this->characteristic->create($request->all());
		
		return redirect(route('characteristics.index'))->with('message', 'success|Característica criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Característica');
		
		return $this->view('characteristics.edit', [
			'characteristic' => $this->characteristic->find($id)
		]);
	}
	
	public function update(CharacteristicRequest $request, $id)
	{
		$this->characteristic->find($id)->update($request->all());
		
		return redirect(route('characteristics.index'))->with('message', 'success|Característica atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->characteristic->destroy($id);
		
		return response()->json([
			'message' => 'Característica excluída com sucesso!',
		]);
	}
}
