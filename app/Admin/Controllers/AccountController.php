<?php
namespace App\Admin\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Admin\Requests\AccountRequest;

class AccountController extends BaseController
{
	protected $account;

	public function __construct()
	{
		parent::__construct();
	
		$this->middleware(function($request, $next) {
			$this->account = Auth::guard('admin')->user();
			
			return $next($request);
		});
	}
	
	public function edit()
	{
		$this->head->setTitle('Editar Conta');
	
		return $this->view('account.edit', [
			'account' => $this->account
		]);
	}
	
	public function update(AccountRequest $request)
	{
		$this->account->update($request->all());
		
		return redirect(route('account.edit'))->with('message', 'success|Conta atualizada com sucesso');
	}
	
	public function password()
	{
		$this->head->setTitle('Alterar Senha');
		
		return $this->view('account.password', [
			'account' => $this->account
		]);
	}
	
	public function updatePassword(AccountRequest $request)
	{
		$this->account->update($request->all());
		
		return redirect(route('account.edit'))->with('message', 'success|Senha atualizada com sucesso');
	}
}
