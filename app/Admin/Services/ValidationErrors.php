<?php
namespace App\Admin\Services;

use Illuminate\Support\MessageBag;

class ValidationErrors
{
	private $errors;
	
	public function __construct()
	{
		$this->errors = session('errors', new MessageBag);
	}
	
	public function getErrors()
	{
		return $this->errors;
	}
}
