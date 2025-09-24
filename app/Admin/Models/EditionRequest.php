<?php
namespace App\Admin\Models;

use App\Common\Models\EditionRequest as BaseEditionRequest;
use App\Admin\Presenters\BasePresenter;

class EditionRequest extends BaseEditionRequest
{
	use BasePresenter;
	
	protected $fillable = [];
    
    protected $hidden = [];

	public function user()
	{
		return parent::user();
	}
}
