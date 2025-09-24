<?php
namespace App\Site\Controllers\Ajax;

use App\Site\Requests\RegisterRequest;
use App\Common\Factories\UserFactory;

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
		return $this->view('login_register', [
			'active' => 'register'
		])->render();
	}
	
	public function store(RegisterRequest $request)
	{
		$this->userFactory->registerWithConfirmation([
			'name' => $request->name,
			'email' => $request->email,
			'password' => $request->password
		]);
		
		return response()->json([
			'message' => 'Enviamos um email para confirmação de conta.'
		]);
	}
}