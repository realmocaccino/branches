<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\ManufacturerRequest;
use App\Admin\Models\Manufacturer;

class ManufacturerController extends BaseController
{
	protected $manufacturer;

	public function __construct(Manufacturer $manufacturer)
	{
		parent::__construct();
		
		$this->manufacturer = $manufacturer;
	}

	public function index()
	{
		$this->head->setTitle('Fabricantes');
		
		return $this->view('manufacturers.index')->with([
			'manufacturers' => $this->manufacturer->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma fabricante encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Fabricante');
		
		return $this->view('manufacturers.create');
	}
	
	public function store(ManufacturerRequest $request)
	{
		$this->manufacturer->create($request->all());
		
		return redirect(route('manufacturers.index'))->with('message', 'success|Fabricante criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Fabricante');
		
		return $this->view('manufacturers.edit', [
			'manufacturer' => $this->manufacturer->find($id)
		]);
	}
	
	public function update(ManufacturerRequest $request, $id)
	{
		$this->manufacturer->find($id)->update($request->all());
		
		return redirect(route('manufacturers.index'))->with('message', 'success|Fabricante atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->manufacturer->destroy($id);
		
		return response()->json([
			'message' => 'Fabricante excluída com sucesso!',
		]);
	}
}
