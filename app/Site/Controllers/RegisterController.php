<?php
namespace App\Site\Controllers;

use App\Site\Requests\RegisterRequest;
use App\Common\Factories\UserFactory;
use App\Common\Helpers\Authentication;

class RegisterController extends BaseController
{
	private $userFactory;

	public function __construct(UserFactory $userFactory)
	{
		parent::__construct();

		$this->userFactory = $userFactory;
	}

	public function index()
	{
		$this->head->setTitle('Cadastro');
		
		return $this->view('register.index');
	}
	
	public function store(RegisterRequest $request)
	{
		$this->userFactory->registerWithConfirmation([
			'name' => $request->name,
			'email' => $request->email,
			'password' => $request->password
		]);
		
		return redirect()->route('home')->with('alert', 'info|Enviamos um email para confirmação de conta.|false');
	}
	
	public function confirm($token)
	{
		$user = $this->userFactory->confirm($token);
		
		$authentication = new Authentication('site');
		$authentication->login($user, true);
		
		return $authentication->redirect('home')->with('alert', 'success|Sua conta foi confirmada com sucesso.');
	}
}