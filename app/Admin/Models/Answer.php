<?php
namespace App\Admin\Models;

use App\Common\Models\Answer as BaseAnswer;
use App\Admin\Presenters\BasePresenter;

class Answer extends BaseAnswer
{
	use BasePresenter;
	
	protected $fillable = [
	    'text',
	    'status'
	];
    
    protected $hidden = [];

	public function game()
	{
		return parent::game();
	}
	
	public function discussion()
	{
		return parent::discussion();
	}
	
	public function user()
	{
		return parent::user();
	}
}