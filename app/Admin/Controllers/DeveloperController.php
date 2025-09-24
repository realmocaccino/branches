<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\DeveloperRequest;
use App\Admin\Models\Developer;

class DeveloperController extends BaseController
{
	protected $developer;
	
	public function __construct(Developer $developer)
	{
		parent::__construct();
		
		$this->developer = $developer;
	}
	
	public function index()
	{
		$this->head->setTitle('Desenvolvedoras');
		
		return $this->view('developers.index')->with([
			'developers' => $this->developer->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma desenvolvedora encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Desenvolvedora');
		
		return $this->view('developers.create');
	}
	
	public function store(DeveloperRequest $request)
	{
		$this->developer->create($request->all());
		
		return redirect(route('developers.index'))->with('message', 'success|Desenvolvedora criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Desenvolvedora');
		
		return $this->view('developers.edit', [
			'developer' => $this->developer->find($id)
		]);
	}
	
	public function update(DeveloperRequest $request, $id)
	{
		$this->developer->find($id)->update($request->all());
		
		return redirect(route('developers.index'))->with('message', 'success|Desenvolvedora atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->developer->destroy($id);
		
		return response()->json([
			'message' => 'Desenvolvedora excluída com sucesso!',
		]);
	}
}
