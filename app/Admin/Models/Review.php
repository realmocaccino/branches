<?php
namespace App\Admin\Models;

use App\Common\Models\Review as BaseReview;
use App\Admin\Presenters\BasePresenter;

class Review extends BaseReview
{
	use BasePresenter;
	
	protected $fillable = [
		'text',
		'has_spoilers'
	];
    
    protected $hidden = [];

	public function game()
	{
		return parent::game();
	}
	
	public function platform()
	{
		return parent::platform();
	}
	
	public function rating()
    {
		return parent::rating();
	}
	
	public function user()
	{
		return parent::user();
	}
}
