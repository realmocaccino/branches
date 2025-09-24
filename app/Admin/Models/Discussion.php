<?php
namespace App\Admin\Models;

use App\Common\Models\Discussion as BaseDiscussion;
use App\Admin\Presenters\BasePresenter;

class Discussion extends BaseDiscussion
{
	use BasePresenter;
	
	protected $fillable = [
	    'title',
	    'text',
	    'status'
	];
    
    protected $hidden = [];

	public function answers()
	{
		return parent::answers();
	}
    
    public function game()
	{
		return parent::game();
	}
	
	public function user()
	{
		return parent::user();
	}
}