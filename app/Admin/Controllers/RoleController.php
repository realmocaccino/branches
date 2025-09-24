<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\RoleRequest;
use App\Admin\Models\Role;

class RoleController extends BaseController
{
	protected $role;

	public function __construct(Role $role)
	{
		parent::__construct();
		
		$this->role = $role;
	}

	public function index()
	{
		$this->head->setTitle('Papéis');
		
		return $this->view('roles.index')->with([
			'roles' => $this->role->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum papel encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Papel');
		
		return $this->view('roles.create');
	}
	
	public function store(RoleRequest $request)
	{
		$this->role->create($request->all());
		
		return redirect(route('roles.index'))->with('message', 'success|Papel criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Papel');
		
		return $this->view('roles.edit', [
			'role' => $this->role->find($id)
		]);
	}
	
	public function update(RoleRequest $request, $id)
	{
		$this->role->find($id)->update($request->all());
		
		return redirect(route('roles.index'))->with('message', 'success|Papel atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->role->destroy($id);
		
		return response()->json([
			'message' => 'Papel excluído com sucesso!',
		]);
	}
}
