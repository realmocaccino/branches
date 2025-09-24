<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\AdministratorRequest;
use App\Admin\Models\Administrator;
use App\Admin\Models\Role;

class AdministratorController extends BaseController
{
	protected $administrator;
	protected $roles;

	public function __construct(Administrator $administrator, Role $role)
	{
		parent::__construct();
		
		$this->administrator = $administrator;
		$this->roles = $role->orderBy('name')->pluck('name', 'id')->all();
	}

	public function index()
	{
		$this->head->setTitle('Administratores');
		
		return $this->view('administrators.index')->with([
			'administrators' => $this->administrator->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma administrador encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Administrador');
		
		return $this->view('administrators.create', [
			'roles' => $this->roles
		]);
	}
	
	public function store(AdministratorRequest $request)
	{
		$this->administrator->create($request->all());
		
		return redirect(route('administrators.index'))->with('message', 'success|Administrador criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Administrador');
		
		return $this->view('administrators.edit', [
			'administrator' => $this->administrator->find($id),
			'roles' => $this->roles
		]);
	}
	
	public function update(AdministratorRequest $request, $id)
	{
		$this->administrator->find($id)->update($request->all());
		
		return redirect(route('administrators.index'))->with('message', 'success|Administrador atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->administrator->destroy($id);
		
		return response()->json([
			'message' => 'Administrador excluído com sucesso!',
		]);
	}
}
