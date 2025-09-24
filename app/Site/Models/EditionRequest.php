<?php
namespace App\Site\Models;

use App\Common\Models\EditionRequest as BaseEditionRequest;

class EditionRequest extends BaseEditionRequest
{
	protected $fillable = [
		'user_id',
		'model_name',
		'entity_id',
		'request'
	];
	
	public function user()
	{
		return parent::user();
	}
}
