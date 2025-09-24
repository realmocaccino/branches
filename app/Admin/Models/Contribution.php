<?php
namespace App\Admin\Models;

use App\Common\Models\Contribution as BaseContribution;
use App\Admin\Presenters\BasePresenter;

class Contribution extends BaseContribution
{
	use BasePresenter;
	
	protected $fillable = [];
    
    protected $hidden = [];

	public function game()
	{
		return parent::game();
	}

    public function user()
    {
		return parent::user();
	}
}
