<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\UserRequest;
use App\Admin\Models\User;

class UserController extends BaseController
{
	protected $User;

	public function __construct(User $user)
	{
		parent::__construct();
		
		$this->user = $user;
	}

	public function index()
	{
		$this->head->setTitle('Usuários');
		
		return $this->view('users.index')->with([
			'users' => $this->user->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum usuário encontrado']
		]);
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Usuário');
		
		return $this->view('users.edit', [
			'user' => $this->user->find($id)
		]);
	}
	
	public function update(UserRequest $request, $id)
	{
		$this->user->find($id)->update($request->all());
		
		return redirect(route('users.index'))->with('message', 'success|Usuário atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->user->find($id)->delete();
		
		return response()->json([
			'message' => 'Usuário excluído com sucesso!',
		]);
	}
}
